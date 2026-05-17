<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Boost your profile visibility and apply to premium jobs.',
                'features' => [
                    'Featured profile in search results',
                    'Apply to premium jobs',
                    '5 ATS CV generations per month',
                    'Email support',
                ],
                'type' => 'subscription',
                'price_monthly_usd' => 9.99,
                'price_yearly_usd' => 99.00,
                'price_onetime_usd' => null,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 10,
                'cta_label' => 'Subscribe Now',
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Everything in Starter plus unlimited ATS CVs and priority support.',
                'features' => [
                    'Everything in Starter',
                    'Unlimited ATS CV generations',
                    'Priority email & chat support',
                    'Higher search ranking',
                    'Resume reviewed by experts',
                ],
                'type' => 'subscription',
                'price_monthly_usd' => 19.99,
                'price_yearly_usd' => 199.00,
                'price_onetime_usd' => null,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 20,
                'cta_label' => 'Subscribe Now',
            ],
            [
                'name' => 'ATS CV Generation',
                'slug' => 'ats-cv',
                'description' => 'Upload your CV and get an ATS-optimized version — one-time fee per CV.',
                'features' => [
                    'AI-rewritten ATS-friendly CV',
                    'PDF + DOCX download',
                    'Standard sections & keywords',
                    'Delivered in under 2 minutes',
                ],
                'type' => 'one_time',
                'price_monthly_usd' => null,
                'price_yearly_usd' => null,
                'price_onetime_usd' => 4.99,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 30,
                'cta_label' => 'Generate ATS CV',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
