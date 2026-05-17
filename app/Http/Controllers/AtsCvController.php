<?php

namespace App\Http\Controllers;

use App\Models\AtsCvPurchase;
use App\Models\Plan;
use App\Models\VatRate;
use App\Services\CountryContext;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AtsCvController extends Controller
{
    public function __construct(protected StripeService $stripe) {}

    public function showUpload(Plan $plan)
    {
        abort_unless($plan->is_active && $plan->type === 'one_time', 404);
        return view('ats.upload', compact('plan'));
    }

    public function checkout(Request $request, Plan $plan, CountryContext $countryContext)
    {
        if (! $plan->is_active || $plan->type !== 'one_time') {
            return back()->with('error', 'This plan is not available.');
        }

        $user = $request->user();
        if (! $user->isSeeker()) {
            return back()->with('error', 'Only jobseekers can purchase ATS CV generation.');
        }

        // Optional CV upload — if user provides a file, save it and link the
        // purchase to it. Otherwise they upload after payment via the dashboard.
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:8192',
            'target_role' => 'nullable|string|max:120',
        ]);

        $vat = VatRate::forCountry($countryContext->key());

        $sourcePath = null;
        if ($request->hasFile('cv')) {
            $sourcePath = $request->file('cv')->store(
                'ats-cv/sources/' . $user->id,
                'public'
            );
        }

        $purchase = AtsCvPurchase::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'status'          => 'pending_payment',
            'source_cv_path'  => $sourcePath,
            'country_key'     => $vat->country_key,
            'vat_rate'        => (float) $vat->rate,
            'base_amount_usd' => (float) $plan->price_onetime_usd,
            'vat_amount_usd'  => round((float) $plan->price_onetime_usd * (float) $vat->rate / 100, 2),
            'total_amount_usd'=> round((float) $plan->price_onetime_usd + ((float) $plan->price_onetime_usd * (float) $vat->rate / 100), 2),
            'rewrite_payload' => $request->target_role ? ['target_role' => $request->target_role] : null,
        ]);

        try {
            $session = $this->stripe->createOneTimeCheckout(
                user: $user,
                plan: $plan,
                vat:  $vat,
                successUrl: route('ats.index'),
                cancelUrl:  route('pricing'),
                metadata:   ['ats_purchase_id' => (string) $purchase->id],
            );

            $purchase->update(['stripe_checkout_session_id' => $session->id]);

            return redirect($session->url);
        } catch (\Throwable $e) {
            Log::error('Stripe one-time checkout failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error'   => $e->getMessage(),
            ]);
            $purchase->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            return back()->with('error', 'Could not start checkout. Please try again.');
        }
    }

    public function uploadAfterPayment(Request $request, AtsCvPurchase $purchase)
    {
        abort_unless($purchase->user_id === $request->user()->id, 403);
        abort_unless($purchase->status === 'paid' && ! $purchase->source_cv_path, 422);

        $request->validate(['cv' => 'required|file|mimes:pdf,doc,docx|max:8192']);

        $path = $request->file('cv')->store(
            'ats-cv/sources/' . $purchase->user_id,
            'public'
        );

        $purchase->update(['source_cv_path' => $path, 'status' => 'generating']);

        \App\Jobs\GenerateAtsCv::dispatch($purchase->id);

        return back()->with('success', 'CV uploaded — generation started.');
    }

    public function index(Request $request)
    {
        $purchases = $request->user()
            ->atsCvPurchases()
            ->latest()
            ->paginate(15);

        return view('ats.index', compact('purchases'));
    }
}
