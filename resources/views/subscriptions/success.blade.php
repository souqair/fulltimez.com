@extends('layouts.app')

@section('title', 'Subscription Activated — FullTimez')

@section('content')
<section style="background:#f8f9fb; padding:80px 0; min-height:60vh;">
    <div class="container">
        <div style="max-width:580px; margin:0 auto; background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:48px; text-align:center;">
            <div style="width:72px; height:72px; border-radius:50%; background:#dcfce7; color:#16a34a; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:36px;">
                <i class="fas fa-check"></i>
            </div>
            <h2 style="color:#0b1437; margin:0 0 12px; font-weight:700;">Subscription Activated</h2>
            <p style="color:#5b6b8a; margin:0 0 28px; line-height:1.7;">
                Welcome aboard! Your subscription is now active.
                @if($subscription)
                    Your plan: <strong>{{ $subscription->plan->name }}</strong> ({{ ucfirst($subscription->billing_cycle) }}).
                @endif
            </p>
            <a href="{{ route('subscriptions.index') }}" style="display:inline-flex; align-items:center; gap:8px; background:#0b1437; color:#fff; padding:14px 26px; border-radius:10px; font-weight:600; text-decoration:none;">
                Manage Subscription <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection
