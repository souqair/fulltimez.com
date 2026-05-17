@extends('layouts.app')

@section('title', 'My Subscriptions — FullTimez')

@section('content')
<section style="background:#f8f9fb; padding:60px 0; min-height:60vh;">
    <div class="container">
        <h2 style="color:#0b1437; font-weight:700; margin-bottom:24px;">My Subscriptions</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($subscriptions->isEmpty())
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:40px; text-align:center;">
                <p style="color:#5b6b8a; margin:0 0 16px;">You don't have any subscriptions yet.</p>
                <a href="{{ route('pricing') }}" class="btn btn-primary">View Plans</a>
            </div>
        @else
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px,1fr)); gap:16px; margin-bottom:40px;">
                @foreach($subscriptions as $sub)
                    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px;">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:14px;">
                            <h4 style="margin:0; color:#0b1437; font-weight:700;">{{ $sub->plan->name }}</h4>
                            @php
                                $colors = [
                                    'active' => '#16a34a', 'past_due' => '#f59e0b', 'canceled' => '#ef4444',
                                    'incomplete' => '#6b7280', 'paused' => '#6b7280',
                                ];
                                $color = $colors[$sub->status] ?? '#6b7280';
                            @endphp
                            <span style="background:{{ $color }}15; color:{{ $color }}; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600;">{{ ucfirst($sub->status) }}</span>
                        </div>
                        <p style="color:#5b6b8a; font-size:14px; margin:0 0 14px;">
                            ${{ number_format($sub->total_amount_usd, 2) }} / {{ $sub->billing_cycle === 'yearly' ? 'year' : 'month' }}
                            @if($sub->vat_rate > 0)
                                (incl. {{ rtrim(rtrim(number_format($sub->vat_rate, 3), '0'), '.') }}% VAT)
                            @endif
                        </p>
                        @if($sub->current_period_end)
                            <p style="color:#5b6b8a; font-size:13px; margin:0 0 14px;">
                                Renews on {{ $sub->current_period_end->format('M j, Y') }}
                            </p>
                        @endif
                        @if($sub->isActive() && ! $sub->canceled_at)
                            <form method="POST" action="{{ route('subscriptions.cancel', $sub) }}" onsubmit="return confirm('Cancel this subscription? Access continues until period end.')">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm" type="submit">Cancel at period end</button>
                            </form>
                        @elseif($sub->canceled_at)
                            <p style="color:#ef4444; font-size:13px; margin:0;">Cancels on {{ optional($sub->current_period_end)->format('M j, Y') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if($transactions->isNotEmpty())
            <h4 style="color:#0b1437; font-weight:700; margin:30px 0 16px;">Recent Transactions</h4>
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                <table class="table" style="margin:0;">
                    <thead style="background:#f8f9fb;">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>VAT</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $txn)
                            <tr>
                                <td>{{ optional($txn->paid_at ?? $txn->created_at)->format('M j, Y') }}</td>
                                <td><small>{{ class_basename($txn->source_type) }}</small></td>
                                <td>${{ number_format($txn->base_amount_usd, 2) }}</td>
                                <td>${{ number_format($txn->vat_amount_usd, 2) }}</td>
                                <td><strong>${{ number_format($txn->total_amount_usd, 2) }}</strong></td>
                                <td><span class="badge bg-{{ $txn->status === 'succeeded' ? 'success' : ($txn->status === 'failed' ? 'danger' : 'secondary') }}">{{ ucfirst($txn->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
