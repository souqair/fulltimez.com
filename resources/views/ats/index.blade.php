@extends('layouts.app')

@section('title', 'My ATS CVs — FullTimez')

@section('content')
<section style="background:#f8f9fb; padding:60px 0; min-height:60vh;">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
            <h2 style="color:#0b1437; font-weight:700; margin:0;">My ATS CVs</h2>
            <a href="{{ route('pricing') }}#ats" class="btn btn-primary">Generate New ATS CV</a>
        </div>

        @if($purchases->isEmpty())
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:40px; text-align:center;">
                <p style="color:#5b6b8a; margin:0 0 16px;">You haven't generated any ATS CVs yet.</p>
                <a href="{{ route('pricing') }}" class="btn btn-primary">View Plans</a>
            </div>
        @else
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                <table class="table" style="margin:0;">
                    <thead style="background:#f8f9fb;">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>ATS Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ optional($purchase->created_at)->format('M j, Y H:i') }}</td>
                                <td>${{ number_format($purchase->total_amount_usd, 2) }}</td>
                                <td>
                                    @php
                                        $colors = ['paid' => 'info', 'generating' => 'warning', 'completed' => 'success', 'failed' => 'danger', 'pending_payment' => 'secondary'];
                                        $badge = $colors[$purchase->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ str_replace('_', ' ', ucfirst($purchase->status)) }}</span>
                                </td>
                                <td>{{ $purchase->ats_score ? $purchase->ats_score . '/100' : '—' }}</td>
                                <td>
                                    @if($purchase->status === 'completed' && $purchase->generated_cv_path)
                                        <a href="{{ asset('storage/' . $purchase->generated_cv_path) }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                                    @else
                                        <small style="color:#6b7280;">Coming soon</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $purchases->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
