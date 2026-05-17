<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\VatRate;
use App\Services\StripeService;
use Illuminate\Console\Command;

class SyncStripePlans extends Command
{
    protected $signature = 'stripe:sync {--force : Re-create all Stripe products/prices ignoring existing IDs}';

    protected $description = 'Sync local plans + VAT rates with Stripe (create products, prices, tax rates).';

    public function handle(StripeService $stripe): int
    {
        if (! config('services.stripe.secret')) {
            $this->error('STRIPE_SECRET not configured in .env');
            return self::FAILURE;
        }

        if ($this->option('force')) {
            $this->warn('Force mode: clearing Stripe IDs from local DB before sync.');
            Plan::query()->update([
                'stripe_product_id' => null,
                'stripe_price_id_monthly' => null,
                'stripe_price_id_yearly' => null,
                'stripe_price_id_onetime' => null,
            ]);
            VatRate::query()->update(['stripe_tax_rate_id' => null]);
        }

        $this->info('Syncing plans...');
        foreach (Plan::active()->get() as $plan) {
            $stripe->syncPlan($plan);
            $this->line("  ✓ {$plan->slug} → {$plan->stripe_product_id}");
        }

        $this->info('Syncing VAT tax rates...');
        foreach (VatRate::where('is_active', true)->get() as $vat) {
            $id = $stripe->ensureTaxRate($vat);
            $this->line("  ✓ {$vat->country_key} ({$vat->rate}%) → " . ($id ?: 'no tax'));
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}
