<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\VatRate;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;
use Stripe\TaxRate;
use Stripe\Webhook;

class StripeService
{
    protected ?StripeClient $client = null;

    public function __construct()
    {
        // Defer Stripe client creation so a missing key does not break
        // controller instantiation. Throws on first use via client().
    }

    public function client(): StripeClient
    {
        if ($this->client) {
            return $this->client;
        }
        $secret = config('services.stripe.secret');
        if (! $secret) {
            throw new \RuntimeException('STRIPE_SECRET is not configured.');
        }
        return $this->client = new StripeClient($secret);
    }

    /**
     * Ensure a Stripe Customer exists for the given user and return its ID.
     */
    public function ensureCustomer(User $user): string
    {
        if (! empty($user->stripe_customer_id)) {
            return $user->stripe_customer_id;
        }

        $customer = $this->client()->customers->create([
            'email' => $user->email,
            'name'  => $user->name,
            'metadata' => [
                'user_id' => (string) $user->id,
            ],
        ]);

        $user->forceFill(['stripe_customer_id' => $customer->id])->save();

        return $customer->id;
    }

    /**
     * Sync a local Plan to Stripe — creates Product + Prices if missing.
     */
    public function syncPlan(Plan $plan): Plan
    {
        // Product
        if (empty($plan->stripe_product_id)) {
            $product = $this->client()->products->create([
                'name' => $plan->name,
                'description' => $plan->description ?: $plan->name,
                'metadata' => ['plan_slug' => $plan->slug],
            ]);
            $plan->stripe_product_id = $product->id;
        }

        if ($plan->type === 'subscription') {
            if (empty($plan->stripe_price_id_monthly) && $plan->price_monthly_usd) {
                $price = $this->client()->prices->create([
                    'product' => $plan->stripe_product_id,
                    'unit_amount' => (int) round($plan->price_monthly_usd * 100),
                    'currency' => 'usd',
                    'recurring' => ['interval' => 'month'],
                    'metadata' => ['plan_slug' => $plan->slug, 'cycle' => 'monthly'],
                ]);
                $plan->stripe_price_id_monthly = $price->id;
            }

            if (empty($plan->stripe_price_id_yearly) && $plan->price_yearly_usd) {
                $price = $this->client()->prices->create([
                    'product' => $plan->stripe_product_id,
                    'unit_amount' => (int) round($plan->price_yearly_usd * 100),
                    'currency' => 'usd',
                    'recurring' => ['interval' => 'year'],
                    'metadata' => ['plan_slug' => $plan->slug, 'cycle' => 'yearly'],
                ]);
                $plan->stripe_price_id_yearly = $price->id;
            }
        }

        if ($plan->type === 'one_time'
            && empty($plan->stripe_price_id_onetime)
            && $plan->price_onetime_usd) {
            $price = $this->client()->prices->create([
                'product' => $plan->stripe_product_id,
                'unit_amount' => (int) round($plan->price_onetime_usd * 100),
                'currency' => 'usd',
                'metadata' => ['plan_slug' => $plan->slug, 'cycle' => 'onetime'],
            ]);
            $plan->stripe_price_id_onetime = $price->id;
        }

        $plan->save();

        return $plan;
    }

    /**
     * Ensure a Stripe TaxRate exists for the local VatRate.
     */
    public function ensureTaxRate(VatRate $vat): ?string
    {
        if ((float) $vat->rate <= 0) {
            return null;
        }

        if (! empty($vat->stripe_tax_rate_id)) {
            return $vat->stripe_tax_rate_id;
        }

        $taxRate = $this->client()->taxRates->create([
            'display_name' => $vat->label,
            'description'  => $vat->label . ' for ' . $vat->country_name,
            'jurisdiction' => strtoupper($vat->country_key),
            'percentage'   => (float) $vat->rate,
            'inclusive'    => false,
            'metadata'     => ['country_key' => $vat->country_key],
        ]);

        $vat->forceFill(['stripe_tax_rate_id' => $taxRate->id])->save();

        return $taxRate->id;
    }

    /**
     * Create a Checkout Session for a subscription plan.
     */
    public function createSubscriptionCheckout(
        User $user,
        Plan $plan,
        string $billingCycle,
        VatRate $vat,
        string $successUrl,
        string $cancelUrl,
    ): CheckoutSession {
        $priceId = $plan->stripePriceIdFor($billingCycle);

        if (! $priceId) {
            $this->syncPlan($plan);
            $priceId = $plan->fresh()->stripePriceIdFor($billingCycle);
        }

        if (! $priceId) {
            throw new \RuntimeException("Plan {$plan->slug} has no Stripe price for cycle {$billingCycle}.");
        }

        $customerId = $this->ensureCustomer($user);
        $taxRateId  = $this->ensureTaxRate($vat);

        $lineItem = [
            'price'    => $priceId,
            'quantity' => 1,
        ];
        if ($taxRateId) {
            $lineItem['tax_rates'] = [$taxRateId];
        }

        return $this->client()->checkout->sessions->create([
            'mode' => 'subscription',
            'customer' => $customerId,
            'line_items' => [$lineItem],
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => $cancelUrl,
            'metadata' => [
                'user_id'        => (string) $user->id,
                'plan_id'        => (string) $plan->id,
                'billing_cycle'  => $billingCycle,
                'country_key'    => $vat->country_key,
                'vat_rate'       => (string) $vat->rate,
            ],
            'subscription_data' => [
                'metadata' => [
                    'user_id'        => (string) $user->id,
                    'plan_id'        => (string) $plan->id,
                    'billing_cycle'  => $billingCycle,
                    'country_key'    => $vat->country_key,
                ],
            ],
        ]);
    }

    /**
     * Create a Checkout Session for a one-time purchase (ATS CV).
     */
    public function createOneTimeCheckout(
        User $user,
        Plan $plan,
        VatRate $vat,
        string $successUrl,
        string $cancelUrl,
        array $metadata = [],
    ): CheckoutSession {
        $priceId = $plan->stripePriceIdFor('onetime');

        if (! $priceId) {
            $this->syncPlan($plan);
            $priceId = $plan->fresh()->stripePriceIdFor('onetime');
        }

        if (! $priceId) {
            throw new \RuntimeException("Plan {$plan->slug} has no one-time Stripe price.");
        }

        $customerId = $this->ensureCustomer($user);
        $taxRateId  = $this->ensureTaxRate($vat);

        $lineItem = [
            'price'    => $priceId,
            'quantity' => 1,
        ];
        if ($taxRateId) {
            $lineItem['tax_rates'] = [$taxRateId];
        }

        return $this->client()->checkout->sessions->create(array_merge([
            'mode' => 'payment',
            'customer' => $customerId,
            'line_items' => [$lineItem],
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => $cancelUrl,
            'payment_intent_data' => [
                'metadata' => array_merge([
                    'user_id'    => (string) $user->id,
                    'plan_id'    => (string) $plan->id,
                    'country_key'=> $vat->country_key,
                ], $metadata),
            ],
            'metadata' => array_merge([
                'user_id'    => (string) $user->id,
                'plan_id'    => (string) $plan->id,
                'country_key'=> $vat->country_key,
                'kind'       => 'ats_cv',
            ], $metadata),
        ]));
    }

    public function cancelSubscription(string $stripeSubscriptionId, bool $immediately = false): void
    {
        if ($immediately) {
            $this->client()->subscriptions->cancel($stripeSubscriptionId);
        } else {
            $this->client()->subscriptions->update($stripeSubscriptionId, [
                'cancel_at_period_end' => true,
            ]);
        }
    }

    public function constructEvent(string $payload, string $signature): \Stripe\Event
    {
        $secret = config('services.stripe.webhook_secret');
        if (! $secret) {
            throw new \RuntimeException('STRIPE_WEBHOOK_SECRET is not configured.');
        }
        return Webhook::constructEvent($payload, $signature, $secret);
    }
}
