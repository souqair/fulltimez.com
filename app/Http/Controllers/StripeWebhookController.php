<?php

namespace App\Http\Controllers;

use App\Models\AtsCvPurchase;
use App\Models\Plan;
use App\Models\StripeWebhookLog;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VatRate;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __construct(protected StripeService $stripe) {}

    public function handle(Request $request)
    {
        $signature = $request->header('Stripe-Signature');
        $payload   = $request->getContent();

        try {
            $event = $this->stripe->constructEvent($payload, $signature);
        } catch (\Throwable $e) {
            Log::warning('Invalid Stripe webhook signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        $log = StripeWebhookLog::firstOrCreate(
            ['event_id' => $event->id],
            [
                'type'    => $event->type,
                'payload' => $event->toArray(),
                'status'  => 'received',
            ],
        );

        // Idempotency: skip already processed
        if ($log->status === 'processed') {
            return response('OK', 200);
        }

        try {
            match ($event->type) {
                'checkout.session.completed'      => $this->onCheckoutCompleted($event->data->object),
                'invoice.paid', 'invoice.payment_succeeded' => $this->onInvoicePaid($event->data->object),
                'invoice.payment_failed'          => $this->onInvoicePaymentFailed($event->data->object),
                'customer.subscription.created',
                'customer.subscription.updated'   => $this->onSubscriptionUpdated($event->data->object),
                'customer.subscription.deleted'   => $this->onSubscriptionDeleted($event->data->object),
                'payment_intent.succeeded'        => $this->onPaymentIntentSucceeded($event->data->object),
                'payment_intent.payment_failed'   => $this->onPaymentIntentFailed($event->data->object),
                default => $log->update(['status' => 'ignored']),
            };

            if ($log->status !== 'ignored') {
                $log->update(['status' => 'processed', 'processed_at' => now()]);
            }
        } catch (\Throwable $e) {
            Log::error('Stripe webhook handling failed', [
                'event_id' => $event->id,
                'type'     => $event->type,
                'error'    => $e->getMessage(),
            ]);
            $log->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            return response('Handler error', 500);
        }

        return response('OK', 200);
    }

    public function onCheckoutCompleted($session): void
    {
        $metadata = (array) ($session->metadata ?? []);
        $userId   = $metadata['user_id'] ?? null;
        $planId   = $metadata['plan_id'] ?? null;

        if (! $userId || ! $planId) {
            return;
        }

        $user = User::find($userId);
        $plan = Plan::find($planId);
        if (! $user || ! $plan) {
            return;
        }

        // ATS one-time purchase
        if (($metadata['kind'] ?? null) === 'ats_cv' || $session->mode === 'payment') {
            $this->upsertAtsCvPurchase($session, $user, $plan, $metadata);
            return;
        }

        // Subscription was created — the customer.subscription.* events will
        // also fire, but we link the local row here so we know which plan/cycle.
        if ($session->mode === 'subscription' && $session->subscription) {
            $vat = VatRate::forCountry($metadata['country_key'] ?? null);
            $cycle = $metadata['billing_cycle'] ?? 'monthly';
            $base = (float) $plan->priceFor($cycle);
            $calc = $vat->calculate($base);

            Subscription::updateOrCreate(
                ['stripe_subscription_id' => $session->subscription],
                [
                    'user_id'           => $user->id,
                    'plan_id'           => $plan->id,
                    'stripe_customer_id'=> $session->customer,
                    'status'            => 'active',
                    'billing_cycle'     => $cycle,
                    'country_key'       => $metadata['country_key'] ?? null,
                    'vat_rate'          => (float) ($metadata['vat_rate'] ?? $vat->rate),
                    'base_amount_usd'   => $calc['base'],
                    'vat_amount_usd'    => $calc['vat'],
                    'total_amount_usd'  => $calc['total'],
                ],
            );
        }
    }

    protected function onInvoicePaid($invoice): void
    {
        $subscriptionId = $invoice->subscription ?? null;
        if (! $subscriptionId) {
            return;
        }

        $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();
        if (! $subscription) {
            return;
        }

        $subscription->update([
            'status'               => 'active',
            'current_period_start' => isset($invoice->period_start) ? now()->createFromTimestamp($invoice->period_start) : $subscription->current_period_start,
            'current_period_end'   => isset($invoice->period_end)   ? now()->createFromTimestamp($invoice->period_end)   : $subscription->current_period_end,
        ]);

        $total = ($invoice->amount_paid ?? 0) / 100;
        $tax   = ($invoice->tax ?? 0) / 100;
        $base  = max(0, $total - $tax);

        Transaction::updateOrCreate(
            ['stripe_invoice_id' => $invoice->id],
            [
                'user_id'             => $subscription->user_id,
                'source_type'         => Subscription::class,
                'source_id'           => $subscription->id,
                'stripe_payment_intent_id' => $invoice->payment_intent ?? null,
                'base_amount_usd'     => $base,
                'vat_amount_usd'      => $tax,
                'total_amount_usd'    => $total,
                'currency'            => strtoupper($invoice->currency ?? 'USD'),
                'country_key'         => $subscription->country_key,
                'status'              => 'succeeded',
                'paid_at'             => now(),
            ],
        );
    }

    protected function onInvoicePaymentFailed($invoice): void
    {
        $subscriptionId = $invoice->subscription ?? null;
        if (! $subscriptionId) {
            return;
        }

        $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();
        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
        }

        Transaction::updateOrCreate(
            ['stripe_invoice_id' => $invoice->id],
            [
                'user_id'         => $subscription?->user_id,
                'source_type'     => Subscription::class,
                'source_id'       => $subscription?->id,
                'base_amount_usd' => 0,
                'vat_amount_usd'  => 0,
                'total_amount_usd'=> ($invoice->amount_due ?? 0) / 100,
                'currency'        => strtoupper($invoice->currency ?? 'USD'),
                'status'          => 'failed',
                'failure_reason'  => 'invoice.payment_failed',
            ],
        );
    }

    protected function onSubscriptionUpdated($stripeSubscription): void
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription->id)->first();
        if (! $subscription) {
            return;
        }

        $subscription->update([
            'status' => $stripeSubscription->status,
            'current_period_start' => isset($stripeSubscription->current_period_start) ? now()->createFromTimestamp($stripeSubscription->current_period_start) : null,
            'current_period_end'   => isset($stripeSubscription->current_period_end)   ? now()->createFromTimestamp($stripeSubscription->current_period_end)   : null,
            'canceled_at' => isset($stripeSubscription->canceled_at) && $stripeSubscription->canceled_at ? now()->createFromTimestamp($stripeSubscription->canceled_at) : null,
            'ends_at'     => isset($stripeSubscription->ended_at) && $stripeSubscription->ended_at ? now()->createFromTimestamp($stripeSubscription->ended_at) : null,
        ]);
    }

    protected function onSubscriptionDeleted($stripeSubscription): void
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription->id)->first();
        if (! $subscription) {
            return;
        }
        $subscription->update([
            'status'  => 'canceled',
            'ends_at' => now(),
        ]);
    }

    protected function onPaymentIntentSucceeded($paymentIntent): void
    {
        $purchase = AtsCvPurchase::where('stripe_payment_intent_id', $paymentIntent->id)->first();
        if (! $purchase) {
            return;
        }

        $purchase->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        $total = ($paymentIntent->amount_received ?? 0) / 100;
        Transaction::updateOrCreate(
            ['stripe_payment_intent_id' => $paymentIntent->id],
            [
                'user_id'         => $purchase->user_id,
                'source_type'     => AtsCvPurchase::class,
                'source_id'       => $purchase->id,
                'base_amount_usd' => $purchase->base_amount_usd,
                'vat_amount_usd'  => $purchase->vat_amount_usd,
                'total_amount_usd'=> $total > 0 ? $total : $purchase->total_amount_usd,
                'currency'        => strtoupper($paymentIntent->currency ?? 'USD'),
                'country_key'     => $purchase->country_key,
                'status'          => 'succeeded',
                'paid_at'         => now(),
            ],
        );

        // Dispatch ATS generation job (Phase 4)
        if (class_exists(\App\Jobs\GenerateAtsCv::class)) {
            \App\Jobs\GenerateAtsCv::dispatch($purchase->id);
        }
    }

    protected function onPaymentIntentFailed($paymentIntent): void
    {
        $purchase = AtsCvPurchase::where('stripe_payment_intent_id', $paymentIntent->id)->first();
        if ($purchase) {
            $purchase->update([
                'status'        => 'failed',
                'error_message' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
            ]);
        }
    }

    protected function upsertAtsCvPurchase($session, User $user, Plan $plan, array $metadata): void
    {
        $vat   = VatRate::forCountry($metadata['country_key'] ?? null);
        $base  = (float) ($plan->price_onetime_usd ?? 0);
        $calc  = $vat->calculate($base);

        AtsCvPurchase::updateOrCreate(
            ['stripe_checkout_session_id' => $session->id],
            [
                'user_id'                 => $user->id,
                'plan_id'                 => $plan->id,
                'stripe_payment_intent_id'=> $session->payment_intent ?? null,
                'status'                  => 'paid',
                'country_key'             => $metadata['country_key'] ?? null,
                'vat_rate'                => (float) $vat->rate,
                'base_amount_usd'         => $calc['base'],
                'vat_amount_usd'          => $calc['vat'],
                'total_amount_usd'        => $calc['total'],
                'paid_at'                 => now(),
            ],
        );
    }
}
