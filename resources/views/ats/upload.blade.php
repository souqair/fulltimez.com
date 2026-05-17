@extends('layouts.app')

@section('title', 'Generate ATS CV — FullTimez')

@section('content')
<section style="background:#f8f9fb; padding:60px 0; min-height:70vh;">
    <div class="container">
        <div style="max-width:680px; margin:0 auto; background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:40px;">
            <h2 style="color:#0b1437; font-weight:700; margin:0 0 8px;">Generate Your ATS CV</h2>
            <p style="color:#5b6b8a; margin:0 0 24px;">Upload your current CV and we'll rewrite it into an ATS-friendly format. Total: <strong>${{ number_format((float)$plan->price_onetime_usd, 2) }}</strong> + VAT (per country).</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('ats.checkout', $plan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom:18px;">
                    <label style="display:block; font-weight:600; color:#0b1437; margin-bottom:6px;">Target role (optional)</label>
                    <input type="text" name="target_role" class="form-control" placeholder="e.g. Senior Software Engineer" style="padding:12px 14px;">
                    <small style="color:#6b7280;">Helps AI tailor keywords for the role you want.</small>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block; font-weight:600; color:#0b1437; margin-bottom:6px;">Upload your CV (PDF, DOC, DOCX — max 8MB)</label>
                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="form-control" style="padding:10px;">
                    <small style="color:#6b7280;">Optional now — you can also upload after payment from your dashboard.</small>
                    @error('cv')
                        <div style="color:#ef4444; font-size:13px; margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" style="background:#0b1437; color:#fff; padding:14px 28px; border:0; border-radius:10px; font-weight:600; font-size:15px;">
                    Continue to Payment →
                </button>
                <a href="{{ route('pricing') }}" style="margin-left:14px; color:#6b7280; text-decoration:none;">Cancel</a>
            </form>
        </div>
    </div>
</section>
@endsection
