@extends('layouts.app')

@section('title', 'Candidate Details')

@section('content')
@php
    $profile = $candidate->seekerProfile;
    $contactUnlocked = auth()->check() && (auth()->user()->isEmployer() || auth()->user()->isAdmin());
    $city = $profile->city ?? 'N/A';
    $country = $profile->country ?? 'UAE';
    $displayName = $profile->full_name ?? $candidate->name;
    $initial = strtoupper(mb_substr($displayName, 0, 1));
    $rawPhoto = $profile->profile_picture ?? null;
    $showImage = false;
    $avatar = null;

    if ($rawPhoto) {
        if (\Illuminate\Support\Str::startsWith($rawPhoto, ['http://', 'https://'])) {
            $avatar = $rawPhoto;
            $showImage = true;
        } else {
            $normalized = ltrim($rawPhoto, '/');
            $absolutePath = public_path($normalized);
            if (file_exists($absolutePath)) {
                $avatar = asset($normalized);
                $showImage = true;
            }
        }
    }
@endphp

<style>
    .candidate-page {
        background: #f4f6fb;
        font-family: 'Roboto', 'Segoe UI', sans-serif;
        padding: 40px 0 80px;
    }
    .candidate-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .candidate-hero {
        background: #1a1a1a;
        border-radius: 24px;
        color: #fff;
        padding: 40px;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        box-shadow: 0 30px 60px rgba(0, 15, 54, 0.35);
        position: relative;
        overflow: hidden;
    }
    .candidate-hero:before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(29,130,236,0.45), transparent 52%);
        pointer-events: none;
    }
    .hero-photo {
        width: 180px;
        height: 180px;
        border-radius: 20px;
        border: 4px solid rgba(255,255,255,0.35);
        overflow: hidden;
        flex: 0 0 auto;
        box-shadow: 0 18px 40px rgba(0,0,0,0.25);
    }
    .hero-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
.hero-photo .letter-avatar {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #1d82ec, #673ab7);
    }
    .hero-meta {
        flex: 1 1 320px;
        position: relative;
        z-index: 1;
    }
    .hero-meta .section-tagline {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: rgba(255,255,255,0.65);
    }
    .hero-meta h1 {
        font-size: 36px;
        font-weight: 700;
        margin: 12px 0 6px;
    }
    .hero-meta .location {
        font-size: 16px;
        color: rgba(255,255,255,0.8);
        margin-bottom: 24px;
    }
    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .hero-badge {
        background: rgba(13,31,74,0.45);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 999px;
        padding: 6px 18px;
        font-size: 13px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .hero-actions {
        flex: 0 0 220px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        z-index: 1;
    }
    .hero-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 14px;
        padding: 12px 20px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .hero-btn.primary {
        background: #1d82ec;
        color: #fff;
        border: none;
        box-shadow: 0 15px 35px rgba(29,130,236,0.45);
    }
    .hero-btn.secondary {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.4);
        color: #fff;
    }
    .hero-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .candidate-grid {
        margin-top: 40px;
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
        gap: 24px;
    }
    .card-panel {
        background: #fff;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 25px 60px rgba(34,44,78,0.08);
        margin-bottom: 24px;
    }
    .panel-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #0d1f4a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .panel-title i {
        color: #1d82ec;
    }
    .section-tagline {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #8390b3;
        margin-bottom: 18px;
    }
    .about-text {
        line-height: 1.8;
        color: #4a5470;
        font-size: 15px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px,1fr));
        gap: 14px;
        margin-top: 20px;
    }
    .info-chip {
        border: 1px solid #e9ecf4;
        border-radius: 16px;
        padding: 12px 16px;
        background: #f9fbff;
    }
    .info-chip span {
        display: block;
    }
    .info-label {
        font-size: 12px;
        color: #8a93b5;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0d1f4a;
        margin-top: 2px;
    }
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 18px;
        border-left: 2px solid #e0e6f5;
        padding-left: 24px;
        margin-top: 16px;
    }
    .timeline-item {
        position: relative;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -33px;
        top: 8px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #1d82ec;
    }
    .timeline-title {
        font-weight: 600;
        font-size: 16px;
        color: #0d1f4a;
    }
    .timeline-meta {
        font-size: 13px;
        color: #7c87aa;
        margin-bottom: 6px;
    }
    .timeline-description {
        color: #4d5775;
        line-height: 1.6;
        font-size: 14px;
    }
    .empty-state {
        border: 1px dashed #cfd6ec;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        color: #8a93b5;
    }
    .contact-card {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .contact-line {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f3fb;
        color: #4a5470;
    }
    .contact-line:last-child {
        border-bottom: 0;
    }
    .contact-line i {
        color: #1d82ec;
        font-size: 18px;
    }
    .locked-info {
        background: #fef6e4;
        border: 1px solid #f9deb5;
        border-radius: 16px;
        padding: 18px;
        color: #8a6300;
        line-height: 1.5;
        font-size: 14px;
    }
    .locked-info a {
        color: #1d82ec;
        font-weight: 600;
        text-decoration: underline;
    }
    .badge-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .skill-badge {
        background: #e8f4ff;
        color: #1d82ec;
        border-radius: 12px;
        padding: 6px 14px;
        font-weight: 500;
        font-size: 13px;
    }
    .cta-card {
        border: 1px solid #e5e9f7;
        border-radius: 20px;
        padding: 28px;
        background: linear-gradient(135deg, #fefefe, #f5f8ff);
        text-align: center;
    }
    .cta-card h4 {
        font-size: 18px;
        margin-bottom: 8px;
        color: #0d1f4a;
    }
    .cta-card p {
        color: #6f7795;
        font-size: 14px;
        margin-bottom: 18px;
    }
    .cta-card .hero-btn {
        width: 100%;
    }
    @media (max-width: 992px) {
        .candidate-grid {
            grid-template-columns: 1fr;
        }
        .hero-actions {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
    }
    @media (max-width: 576px) {
        .candidate-hero {
            padding: 24px;
        }
        .hero-photo {
            width: 120px;
            height: 120px;
        }
    }
</style>

<section class="candidate-page">
    <div class="candidate-shell">
        <div class="candidate-hero">
            <div class="hero-photo">
                @if($showImage && $avatar)
                    <img src="{{ $avatar }}" alt="{{ $displayName }}">
                @else
                    <div class="letter-avatar">{{ $initial }}</div>
                @endif
            </div>
            <div class="hero-meta">
                <span class="section-tagline">Candidate Detail</span>
                <h1>{{ $displayName }}</h1>
                <div class="location">
                    <i class="fas fa-map-marker-alt me-1"></i> {{ $city }}, {{ $country }}
                </div>
                <div class="hero-badges">
                    <span class="hero-badge"><i class="fas fa-user-tie me-1"></i> {{ $profile->current_position ?? 'Role not specified' }}</span>
                    <span class="hero-badge"><i class="fas fa-briefcase me-1"></i> {{ $profile->experience_years ?? 'Experience N/A' }}</span>
                    <span class="hero-badge"><i class="fas fa-money-bill-wave me-1"></i> {{ $profile->expected_salary ?? 'Negotiable' }}</span>
                </div>
            </div>
            <div class="hero-actions">
                @if($contactUnlocked)
                    <a href="mailto:{{ $candidate->email }}" class="hero-btn primary">
                        <i class="fas fa-envelope-open-text"></i> Contact Candidate
                    </a>
                @else
                    <button type="button" class="hero-btn primary" disabled>
                        <i class="fas fa-lock"></i> Contact Locked
                    </button>
                @endif

                @auth
                    @if(auth()->user()->isEmployer())
                        <a href="{{ route('employer.candidates.resume', ['user' => $candidate->id]) }}" target="_blank" class="hero-btn secondary">
                            <i class="fas fa-file-pdf"></i> View CV Template
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.resume', ['user' => $candidate->id]) }}" target="_blank" class="hero-btn secondary">
                            <i class="fas fa-file-pdf"></i> View CV Template
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hero-btn secondary">
                        <i class="fas fa-sign-in-alt"></i> Login to Unlock
                    </a>
                @endauth
            </div>
        </div>

        <div class="candidate-grid">
            <div>
                <div class="card-panel">
                    <div class="panel-title"><i class="fas fa-user-circle"></i> Professional Snapshot</div>
                    <p class="about-text">{{ $profile->bio ?? 'No bio available' }}</p>
                    <div class="info-grid">
                        <div class="info-chip">
                            <span class="info-label">Current Position</span>
                            <span class="info-value">{{ $profile->current_position ?? 'Not specified' }}</span>
                        </div>
                        <div class="info-chip">
                            <span class="info-label">Experience</span>
                            <span class="info-value">{{ $profile->experience_years ?? 'N/A' }}</span>
                        </div>
                        <div class="info-chip">
                            <span class="info-label">Expected Salary</span>
                            <span class="info-value">{{ $profile->expected_salary ?? 'Negotiable' }}</span>
                        </div>
                        <div class="info-chip">
                            <span class="info-label">Nationality</span>
                            <span class="info-value">{{ $profile->nationality ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-panel">
                    <div class="panel-title"><i class="fas fa-briefcase"></i> Work Experience</div>
                    <p class="section-tagline">Employment History</p>
                    @if($candidate->experienceRecords->count())
                        <div class="timeline">
                            @foreach($candidate->experienceRecords as $experience)
                                <div class="timeline-item">
                                    <div class="timeline-title">{{ $experience->job_title }} · {{ $experience->company_name }}</div>
                                    <div class="timeline-meta">
                                        {{ optional($experience->start_date)->format('M Y') }} - {{ $experience->is_current ? 'Present' : optional($experience->end_date)->format('M Y') }}
                                    </div>
                                    @if($experience->description)
                                        <div class="timeline-description">{{ $experience->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">No work experience has been added for this candidate.</div>
                    @endif
                </div>

                <div class="card-panel">
                    <div class="panel-title"><i class="fas fa-graduation-cap"></i> Education</div>
                    <p class="section-tagline">Academic Background</p>
                    @if($candidate->educationRecords->count())
                        <div class="timeline">
                            @foreach($candidate->educationRecords as $education)
                                <div class="timeline-item">
                                    <div class="timeline-title">{{ $education->degree }} in {{ $education->field_of_study }}</div>
                                    <div class="timeline-meta">{{ $education->institution_name }}</div>
                                    <div class="timeline-description">
                                        {{ optional($education->start_date)->format('Y') }} - {{ $education->is_current ? 'Present' : optional($education->end_date)->format('Y') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">No education records available.</div>
                    @endif
                </div>

                <div class="card-panel">
                    <div class="panel-title"><i class="fas fa-award"></i> Certifications</div>
                    <p class="section-tagline">Credentials & Courses</p>
                    @if($candidate->certificates->count())
                        <div class="timeline">
                            @foreach($candidate->certificates as $certificate)
                                <div class="timeline-item">
                                    <div class="timeline-title">{{ $certificate->certificate_name }}</div>
                                    <div class="timeline-meta">{{ $certificate->issuing_organization }}</div>
                                    <div class="timeline-description">Issued {{ optional($certificate->issue_date)->format('M Y') }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">No certifications added yet.</div>
                    @endif
                </div>

                @if($profile && $profile->skills && count($profile->skills))
                <div class="card-panel">
                    <div class="panel-title"><i class="fas fa-cogs"></i> Skill Stack</div>
                    <p class="section-tagline">Core & Supporting Skills</p>
                    <div class="badge-cloud">
                        @foreach($profile->skills as $skill)
                            <span class="skill-badge">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div>
                <div class="card-panel">
                    <div class="panel-title">
                        <i class="fas fa-address-card"></i>
                        {{ $contactUnlocked ? 'Contact Information' : 'Additional Information' }}
                    </div>
                    <div class="contact-card">
                        @if($contactUnlocked)
                            <div class="contact-line">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Email</strong>
                                    <div>{{ $candidate->email }}</div>
                                </div>
                            </div>
                            <div class="contact-line">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Phone</strong>
                                    <div>{{ $candidate->phone ?? 'Not provided' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="locked-info">
                                <strong>Contact details are protected.</strong><br>
                                Only verified employers can reach out to this candidate. Please
                                <a href="{{ route('employer.register') }}">register as an employer</a>
                                or log in to unlock access.
                            </div>
                        @endif
                        @if($profile)
                            <div class="contact-line">
                                <i class="fas fa-globe"></i>
                                <div>
                                    <strong>Nationality</strong>
                                    <div>{{ $profile->nationality ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="contact-line">
                                <i class="fas fa-money-bill-wave"></i>
                                <div>
                                    <strong>Expected Salary</strong>
                                    <div>{{ $profile->expected_salary ?? 'Negotiable' }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-panel cta-card">
                    <h4>Download the FullTimez App</h4>
                    <p>Stay connected to top talent, manage applications, and receive instant alerts wherever you are.</p>
                    <a href="#" class="hero-btn primary">
                        <i class="fas fa-mobile-alt"></i>
                        Get the App
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
