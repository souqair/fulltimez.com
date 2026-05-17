@extends('layouts.app')

@section('title', 'Pricing — FullTimez')

@section('content')
<style>
    .pricing-wrap { background: #f8f9fb; padding: 80px 0; }
    .pricing-title { text-align: center; font-weight: 700; color: #0b1437; max-width: 760px; margin: 0 auto 12px; line-height: 1.2; }
    .pricing-sub   { text-align: center; color: #5b6b8a; max-width: 640px; margin: 0 auto 36px; }

    .billing-toggle { display: inline-flex; background: #fff; border: 1px solid #e5e7eb; border-radius: 999px; padding: 4px; margin: 0 auto 40px; }
    .billing-toggle button { border: 0; background: transparent; padding: 10px 22px; border-radius: 999px; font-weight: 600; color: #6b7280; cursor: pointer; transition: all .2s; }
    .billing-toggle button.is-active { background: #0b1437; color: #fff; }
    .billing-toggle .save-pill { font-size: 11px; background: #16a34a; color: #fff; padding: 2px 8px; border-radius: 999px; margin-left: 6px; }

    .plan-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 980px; margin: 0 auto; }
    .plan-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 32px; position: relative; transition: transform .2s, box-shadow .2s; }
    .plan-card:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(11,20,55,.08); }
    .plan-card.is-featured { border-color: #0b1437; box-shadow: 0 12px 32px rgba(11,20,55,.10); }
    .plan-card .ribbon { position: absolute; top: -12px; right: 24px; background: #0b1437; color: #fff; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .plan-card h3 { font-weight: 700; color: #0b1437; margin: 0 0 8px; }
    .plan-card .plan-desc { color: #5b6b8a; font-size: 14.5px; line-height: 1.6; margin-bottom: 22px; }
    .plan-card .plan-features { list-style: none; padding: 0; margin: 0 0 28px; }
    .plan-card .plan-features li { padding: 8px 0 8px 28px; position: relative; color: #1f2a44; font-size: 14.5px; }
    .plan-card .plan-features li::before { content: '✓'; position: absolute; left: 0; top: 8px; color: #16a34a; font-weight: 700; }

    .plan-price-row { display: flex; align-items: baseline; gap: 6px; }
    .plan-price { font-size: 36px; font-weight: 700; color: #0b1437; }
    .plan-cycle { color: #6b7280; font-size: 14px; }
    .plan-starts-at { color: #6b7280; font-size: 13px; margin-bottom: 4px; }
    .plan-vat-line { color: #6b7280; font-size: 13px; margin-bottom: 20px; }
    .plan-vat-line strong { color: #0b1437; }

    .btn-plan { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px 22px; background: #0b1437; color: #fff; border: 0; border-radius: 10px; font-weight: 600; font-size: 15px; text-decoration: none; transition: background .2s; }
    .btn-plan:hover { background: #1d2a5e; color: #fff; }
    .btn-plan.btn-outline { background: #fff; color: #0b1437; border: 1px solid #0b1437; }
    .btn-plan.btn-outline:hover { background: #0b1437; color: #fff; }

    .country-strip { text-align: center; margin: 0 auto 32px; max-width: 720px; color: #5b6b8a; font-size: 13px; }
    .country-strip strong { color: #0b1437; }

    .onetime-section { margin-top: 60px; }
    .onetime-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 28px 32px; max-width: 760px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
    .onetime-card h4 { margin: 0 0 6px; color: #0b1437; font-weight: 700; }
    .onetime-card p { margin: 0; color: #5b6b8a; font-size: 14px; }
    .onetime-card .otp-price { font-size: 28px; font-weight: 700; color: #0b1437; }

    .faq-section { background: #f8f9fb; padding: 80px 0 100px; }
    .faq-title { text-align: center; font-weight: 700; color: #0b1437; margin: 0 auto 40px; }
    .faq-list { max-width: 880px; margin: 0 auto; }
    .faq-item { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 12px; overflow: hidden; }
    .faq-question { padding: 20px 24px; background: transparent; border: 0; width: 100%; display: flex; align-items: center; justify-content: space-between; cursor: pointer; font-weight: 600; color: #0b1437; font-size: 15.5px; text-align: left; }
    .faq-question .plus { font-size: 22px; color: #6b7280; transition: transform .2s; }
    .faq-item.is-open .plus { transform: rotate(45deg); }
    .faq-answer { padding: 0 24px; max-height: 0; overflow: hidden; transition: max-height .25s ease, padding .25s ease; color: #5b6b8a; line-height: 1.7; }
    .faq-item.is-open .faq-answer { padding: 0 24px 22px; max-height: 600px; }

    @media (max-width: 720px) {
        .pricing-wrap { padding: 50px 0; }
        .plan-card { padding: 26px 22px; }
    }
</style>

<section class="pricing-wrap">
    <div class="container">
        <h1 class="pricing-title">Boost your career — pick a plan</h1>
        <p class="pricing-sub">All prices are in USD. VAT is calculated automatically based on your country.</p>

        <div class="country-strip">
            Showing pricing for <strong>{{ $vat->country_name }}</strong> — {{ $vat->label }}
            @if($vat->rate > 0)
                <strong>{{ rtrim(rtrim(number_format($vat->rate, 3), '0'), '.') }}%</strong>
            @else
                <strong>0%</strong>
            @endif
        </div>

        <div style="text-align:center">
            <div class="billing-toggle" role="tablist">
                <button type="button" class="is-active" data-cycle="monthly">Monthly</button>
                <button type="button" data-cycle="yearly">Yearly <span class="save-pill">Save 17%</span></button>
            </div>
        </div>

        <div class="plan-grid">
            @foreach($subscriptionPlans as $plan)
                <div class="plan-card {{ $plan->is_featured ? 'is-featured' : '' }}">
                    @if($plan->is_featured)
                        <span class="ribbon">Most Popular</span>
                    @endif

                    <h3>{{ $plan->name }}</h3>
                    <p class="plan-desc">{{ $plan->description }}</p>

                    <ul class="plan-features">
                        @foreach((array) $plan->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    @if($plan->monthly)
                        <div class="plan-starts-at">Starts at</div>
                        <div class="plan-price-row plan-monthly-price">
                            <span class="plan-price">${{ number_format($plan->monthly['base'], 2) }}</span>
                            <span class="plan-cycle">/mo</span>
                        </div>
                        <div class="plan-vat-line plan-monthly-vat">
                            @if($plan->monthly['vat'] > 0)
                                + {{ $vat->label }} ({{ rtrim(rtrim(number_format($vat->rate, 3), '0'), '.') }}%) ${{ number_format($plan->monthly['vat'], 2) }} = <strong>${{ number_format($plan->monthly['total'], 2) }}</strong>/mo
                            @else
                                No tax for {{ $vat->country_name }}
                            @endif
                        </div>
                    @endif

                    @if($plan->yearly)
                        <div class="plan-yearly-price" style="display:none">
                            <div class="plan-starts-at">Starts at</div>
                            <div class="plan-price-row">
                                <span class="plan-price">${{ number_format($plan->yearly['base'], 2) }}</span>
                                <span class="plan-cycle">/yr</span>
                            </div>
                            <div class="plan-vat-line">
                                @if($plan->yearly['vat'] > 0)
                                    + {{ $vat->label }} ({{ rtrim(rtrim(number_format($vat->rate, 3), '0'), '.') }}%) ${{ number_format($plan->yearly['vat'], 2) }} = <strong>${{ number_format($plan->yearly['total'], 2) }}</strong>/yr
                                @else
                                    No tax for {{ $vat->country_name }}
                                @endif
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('subscribe.checkout', $plan) }}" class="plan-form">
                        @csrf
                        <input type="hidden" name="billing_cycle" value="monthly" class="cycle-input">
                        <button type="submit" class="btn-plan {{ $plan->is_featured ? '' : 'btn-outline' }}">
                            {{ $plan->cta_label ?? 'Subscribe Now' }}
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        @if($oneTimePlans->count())
            <div class="onetime-section">
                @foreach($oneTimePlans as $plan)
                    <div class="onetime-card">
                        <div style="flex:1; min-width:240px">
                            <h4>{{ $plan->name }} <span class="otp-price">${{ number_format($plan->onetime['base'], 2) }}</span></h4>
                            <p>{{ $plan->description }}</p>
                            <p style="margin-top:6px; font-size:12.5px">
                                @if($plan->onetime['vat'] > 0)
                                    + {{ $vat->label }} ${{ number_format($plan->onetime['vat'], 2) }} = <strong>${{ number_format($plan->onetime['total'], 2) }}</strong> per CV
                                @else
                                    No tax for {{ $vat->country_name }}
                                @endif
                            </p>
                        </div>
                        <a class="btn-plan" href="{{ route('ats.start', $plan) }}" style="width:auto; display:inline-flex">
                            {{ $plan->cta_label ?? 'Generate ATS CV' }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="faq-section">
    <div class="container">
        <h2 class="faq-title">Frequently Asked Questions</h2>

        <div class="faq-list">
            @foreach($faqs->flatten() as $faq)
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        <span>{{ $faq->question }}</span>
                        <span class="plus">+</span>
                    </button>
                    <div class="faq-answer">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(function (btn) {
            btn.addEventListener('click', function () {
                btn.parentElement.classList.toggle('is-open');
            });
        });

        // Billing cycle toggle
        var toggleBtns = document.querySelectorAll('.billing-toggle button');
        toggleBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var cycle = btn.dataset.cycle;
                toggleBtns.forEach(function (b) { b.classList.remove('is-active'); });
                btn.classList.add('is-active');

                document.querySelectorAll('.plan-card').forEach(function (card) {
                    var monthly = card.querySelector('.plan-monthly-price, .plan-monthly-vat');
                    var yearly  = card.querySelector('.plan-yearly-price');
                    var monthlyBlocks = card.querySelectorAll('.plan-monthly-price, .plan-monthly-vat');

                    if (cycle === 'yearly') {
                        monthlyBlocks.forEach(function (el) { el.style.display = 'none'; });
                        if (yearly) yearly.style.display = 'block';
                    } else {
                        monthlyBlocks.forEach(function (el) { el.style.display = ''; });
                        if (yearly) yearly.style.display = 'none';
                    }
                });

                document.querySelectorAll('.cycle-input').forEach(function (input) {
                    input.value = cycle;
                });
            });
        });
    });
</script>
@endsection
