<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\VatRate;
use App\Services\CountryContext;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function __construct(protected StripeService $stripe) {}

    public function checkout(Request $request, Plan $plan, CountryContext $countryContext)
    {
        $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        if (! $plan->is_active || $plan->type !== 'subscription') {
            return back()->with('error', 'This plan is not available.');
        }

        $user = $request->user();
        if (! $user->isSeeker()) {
            return back()->with('error', 'Only jobseekers can subscribe to these plans.');
        }

        $vat = VatRate::forCountry($countryContext->key());

        try {
            $session = $this->stripe->createSubscriptionCheckout(
                user: $user,
                plan: $plan,
                billingCycle: $request->billing_cycle,
                vat: $vat,
                successUrl: route('subscribe.success'),
                cancelUrl:  route('pricing'),
            );

            return redirect($session->url);
        } catch (\Throwable $e) {
            Log::error('Stripe subscription checkout failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error'   => $e->getMessage(),
                'class'   => get_class($e),
            ]);
            $detail = config('app.debug')
                ? ' ['.class_basename($e).': '.$e->getMessage().']'
                : '';
            return back()->with('error', 'Could not start checkout. Please try again.' . $detail);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            try {
                $session = $this->stripe->client()->checkout->sessions->retrieve($sessionId);
                app(StripeWebhookController::class)->onCheckoutCompleted($session);
            } catch (\Throwable $e) {
                Log::warning('Sync subscription on success failed', [
                    'session_id' => $sessionId,
                    'error'      => $e->getMessage(),
                ]);
            }
        }

        $subscription = Subscription::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        return view('subscriptions.success', compact('subscription'));
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->stripe_customer_id && $user->subscriptions()->count() === 0) {
            $this->syncFromStripe($user);
        }

        $subscriptions = $user->subscriptions()->with('plan')->latest()->get();
        $transactions  = $user->transactions()->latest()->take(20)->get();

        return view('subscriptions.index', compact('subscriptions', 'transactions'));
    }

    protected function syncFromStripe(\App\Models\User $user): void
    {
        try {
            $sessions = $this->stripe->client()->checkout->sessions->all([
                'customer' => $user->stripe_customer_id,
                'limit'    => 20,
            ]);
            foreach ($sessions->data as $session) {
                if ($session->payment_status !== 'paid') {
                    continue;
                }
                app(StripeWebhookController::class)->onCheckoutCompleted($session);
            }
        } catch (\Throwable $e) {
            Log::warning('Sync subscriptions from Stripe failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function cancel(Request $request, Subscription $subscription)
    {
        abort_unless($subscription->user_id === $request->user()->id, 403);

        if (! $subscription->stripe_subscription_id) {
            return back()->with('error', 'This subscription cannot be canceled.');
        }

        try {
            $this->stripe->cancelSubscription($subscription->stripe_subscription_id, immediately: false);
            $subscription->update(['canceled_at' => now()]);
            return back()->with('success', 'Subscription will end at the period end.');
        } catch (\Throwable $e) {
            Log::error('Stripe subscription cancel failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Could not cancel subscription.');
        }
    }
}
