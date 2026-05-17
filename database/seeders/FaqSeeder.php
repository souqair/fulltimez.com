<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is included in the Starter plan?',
                'answer'   => 'Starter includes a featured profile, access to premium jobs and 5 ATS CV generations per month. Cancel anytime.',
                'category' => 'plans',
                'sort_order' => 10,
            ],
            [
                'question' => 'How does VAT work?',
                'answer'   => 'All prices are shown in USD. VAT is calculated and added at checkout based on the country you are subscribing from (Pakistan 18%, UAE 5%, Saudi Arabia 15%, others 0%).',
                'category' => 'billing',
                'sort_order' => 20,
            ],
            [
                'question' => 'Can I cancel my subscription anytime?',
                'answer'   => 'Yes. You can cancel from your dashboard at any time. You will keep access until the end of your current billing period.',
                'category' => 'billing',
                'sort_order' => 30,
            ],
            [
                'question' => 'What is an ATS CV?',
                'answer'   => 'An ATS (Applicant Tracking System) CV is a resume formatted so it can be reliably parsed by recruiter software. We use AI to rewrite your existing CV using standard sections, industry keywords, and a clean single-column layout.',
                'category' => 'ats',
                'sort_order' => 40,
            ],
            [
                'question' => 'How long does ATS CV generation take?',
                'answer'   => 'Most CVs are generated within 1–2 minutes after payment. You will receive the PDF and DOCX in your dashboard and via email.',
                'category' => 'ats',
                'sort_order' => 50,
            ],
            [
                'question' => 'Will I be charged for multiple ATS CVs within one subscription?',
                'answer'   => 'Starter includes 5 ATS CVs per month, Pro includes unlimited. Beyond your monthly quota, additional CVs are charged at the per-CV rate.',
                'category' => 'ats',
                'sort_order' => 60,
            ],
            [
                'question' => 'Can I change my subscription anytime?',
                'answer'   => 'Yes — upgrade or downgrade from Starter to Pro (or vice versa) from your dashboard. Pro-rated billing applies automatically.',
                'category' => 'billing',
                'sort_order' => 70,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq + ['is_active' => true]
            );
        }
    }
}
