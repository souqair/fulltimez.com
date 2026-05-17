<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Plan;
use App\Models\VatRate;
use App\Services\CountryContext;

class PricingController extends Controller
{
    public function index(CountryContext $countryContext)
    {
        $countryKey = $countryContext->key() ?? 'global';
        $vat = VatRate::forCountry($countryKey);

        $plans = Plan::active()->orderBy('sort_order')->get()->map(function (Plan $plan) use ($vat) {
            $plan->monthly = $plan->price_monthly_usd ? $vat->calculate((float) $plan->price_monthly_usd) : null;
            $plan->yearly  = $plan->price_yearly_usd  ? $vat->calculate((float) $plan->price_yearly_usd)  : null;
            $plan->onetime = $plan->price_onetime_usd ? $vat->calculate((float) $plan->price_onetime_usd) : null;
            return $plan;
        });

        $subscriptionPlans = $plans->where('type', 'subscription')->values();
        $oneTimePlans      = $plans->where('type', 'one_time')->values();

        $faqs = Faq::active()->orderBy('sort_order')->get()->groupBy('category');

        return view('pricing.index', compact(
            'subscriptionPlans',
            'oneTimePlans',
            'faqs',
            'vat',
        ));
    }
}
