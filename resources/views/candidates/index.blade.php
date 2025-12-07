@extends('layouts.app')

@section('title', 'Candidates')

@push('styles')
<style>
body {
    overflow-x: hidden !important;
}

/* Simple Filters Styling */
.filters {
    background: #ffffff;
    border: 1px solid #eee;
    border-radius: 14px;
    padding: 25px;
    margin-bottom: 30px;
}

.filters h3 {
    font-size: 18px;
    font-weight: 700;
    color: #000;
    margin-bottom: 20px;
}

.filters .input-group {
    margin-bottom: 20px;
}

.filters label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.filters .form-control,
.filters select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 13px;
    color: #333;
    background: #fff;
}

.filters .form-control:focus,
.filters select:focus {
    outline: none;
    border-color: #2772e8;
}

.filters .apply_btn {
    width: 100%;
    padding: 12px 20px;
    background: #000;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.filters .apply_btn:hover {
    background: #333;
}

.mobile-search-wrapper {
    margin: 0 0 28px;
}

.mobile-search-card {
    display: none;
}

@media (max-width: 991.98px) {
    .mobile-search-card {
        display: block;
        background: linear-gradient(135deg, #1f2937 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 4px 0 0;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.35);
        color: #f8fafc;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.25);
    }

    .mobile-search-card summary {
        list-style: none;
        cursor: pointer;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 16px;
        font-weight: 600;
        color: #e2e8f0;
        transition: background 0.2s ease;
    }

    .mobile-search-card summary::-webkit-details-marker {
        display: none;
    }

    .mobile-search-card summary::after {
        content: "\25BC";
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .mobile-search-card[open] summary::after {
        transform: rotate(180deg);
    }

    .mobile-search-card summary:hover {
        background: rgba(148, 163, 184, 0.12);
    }

    .mobile-search-card .summary-meta {
        font-size: 13px;
        font-weight: 500;
        color: rgba(226, 232, 240, 0.7);
    }

    .mobile-search-card form {
        padding: 0 20px 20px;
        display: grid;
        gap: 14px;
    }

    .mobile-search-card label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: rgba(226, 232, 240, 0.85);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .mobile-search-card .form-control,
    .mobile-search-card select {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        background: rgba(15, 23, 42, 0.35);
        color: #f8fafc;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 500;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .mobile-search-card .form-control::placeholder {
        color: rgba(203, 213, 225, 0.65);
    }

    .mobile-search-card .form-control:focus,
    .mobile-search-card select:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    .mobile-search-card .mobile-search-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 4px;
    }

    .mobile-search-card button[type="submit"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        color: #f8fafc;
        font-size: 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        box-shadow: 0 16px 30px rgba(79, 70, 229, 0.35);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .mobile-search-card button[type="submit"]:active {
        transform: translateY(1px);
        box-shadow: 0 10px 18px rgba(79, 70, 229, 0.2);
    }

    .mobile-search-card .reset-link {
        display: inline-flex;
        justify-content: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: rgba(226, 232, 240, 0.75);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
}

/* Mobile Responsive Styles */
@media (max-width: 991px) {
    .col-lg-3 {
        display: none !important;
    }
    
    .col-lg-9 {
        width: 100% !important;
        max-width: 100% !important;
        margin-top: 0 !important;
        padding: 0 !important;
    }
    
    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    
    .candidates-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 24px !important;
    }
    
    .section-sub {
        font-size: 14px !important;
    }
    
    .breadcrumb-nav {
        font-size: 24px !important;
    }
}
</style>
@endpush

@section('content')
@php
    $filtersActive = request()->filled('search')
        || request()->filled('experience')
        || request()->filled('salary')
        || request()->filled('country')
        || request()->filled('city')
        || request()->filled('nationality');
    $candidateCount = $candidates->total();
@endphp

<section class="category-wrap innerseeker popular-items mt-5">
    <div style="width: 90%; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Mobile Search Filters -->
        <div class="mobile-search-wrapper d-lg-none">
            <details class="mobile-search-card" {{ $filtersActive ? 'open' : '' }}>
                <summary>
                    <span>Refine Search</span>
                    @if($candidateCount)
                    <span class="summary-meta">{{ number_format($candidateCount) }} candidates</span>
                    @endif
                </summary>
                <form action="{{ route('candidates.index') }}" method="GET">
                    <div>
                        <label for="mobileSearch">Search</label>
                        <input type="text" id="mobileSearch" name="search" class="form-control" placeholder="Name or Position" value="{{ request('search') }}">
                    </div>
                    <div>
                        <label for="mobileExperience">Experience</label>
                        <select id="mobileExperience" name="experience">
                            <option value="">All Experience Levels</option>
                            <option value="0-1" {{ request('experience') == '0-1' ? 'selected' : '' }}>0 - 1 years</option>
                            <option value="2-3" {{ request('experience') == '2-3' ? 'selected' : '' }}>2 - 3 years</option>
                            <option value="3-5" {{ request('experience') == '3-5' ? 'selected' : '' }}>3 - 5 years</option>
                            <option value="5-7" {{ request('experience') == '5-7' ? 'selected' : '' }}>5 - 7 years</option>
                            <option value="7-10" {{ request('experience') == '7-10' ? 'selected' : '' }}>7 - 10 years</option>
                            <option value="10+" {{ request('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileSalary">Expected Salary</label>
                        <select id="mobileSalary" name="salary">
                            <option value="">All Salary Ranges</option>
                            <option value="0-1999" {{ request('salary') == '0-1999' ? 'selected' : '' }}>0 - 1,999</option>
                            <option value="2000-3999" {{ request('salary') == '2000-3999' ? 'selected' : '' }}>2,000 - 3,999</option>
                            <option value="4000-5999" {{ request('salary') == '4000-5999' ? 'selected' : '' }}>4,000 - 5,999</option>
                            <option value="6000-9999" {{ request('salary') == '6000-9999' ? 'selected' : '' }}>6,000 - 9,999</option>
                            <option value="10000-14999" {{ request('salary') == '10000-14999' ? 'selected' : '' }}>10,000 - 14,999</option>
                            <option value="15000+" {{ request('salary') == '15000+' ? 'selected' : '' }}>15,000+</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileCountry">Country</label>
                        <select id="mobileCountry" name="country">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}" {{ request('country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="mobileCity">City</label>
                        <select id="mobileCity" name="city">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->name }}" {{ request('city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="mobileNationality">Nationality</label>
                        <select id="mobileNationality" name="nationality">
                            <option value="">All Nationalities</option>
                            <option value="UAE" {{ request('nationality') == 'UAE' ? 'selected' : '' }}>UAE</option>
                            <option value="India" {{ request('nationality') == 'India' ? 'selected' : '' }}>India</option>
                            <option value="Pakistan" {{ request('nationality') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                            <option value="Egypt" {{ request('nationality') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                            <option value="USA" {{ request('nationality') == 'USA' ? 'selected' : '' }}>USA</option>
                            <option value="UK" {{ request('nationality') == 'UK' ? 'selected' : '' }}>UK</option>
                            <option value="Bangladesh" {{ request('nationality') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="Philippines" {{ request('nationality') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                            <option value="Sri Lanka" {{ request('nationality') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                        </select>
                    </div>
                    <div class="mobile-search-actions">
                        <button type="submit">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"></circle>
                                <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            </svg>
                            Apply Filters
                        </button>
                        @if($filtersActive)
                        <a href="{{ route('candidates.index') }}" class="reset-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M4.5 4.5L19.5 19.5M19.5 4.5L4.5 19.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Clear filters
                        </a>
                        @endif
                    </div>
                </form>
            </details>
        </div>
        
        <div class="row">
            <!-- Desktop Filters Sidebar -->
            <div class="col-lg-3 fadeInLeft d-none d-lg-block">
                <div class="filters">
                    <h3>Filters</h3>
                    <form action="{{ route('candidates.index') }}" method="GET">
                        <!-- Search -->
                        <div class="input-group">
                            <label>Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Name or Position">
                        </div>

                        <!-- Experience -->
                        <div class="input-group">
                            <label>Experience</label>
                            <select class="form-control" name="experience">
                                <option value="">All Experience Levels</option>
                                <option value="0-1" {{ request('experience') == '0-1' ? 'selected' : '' }}>0 - 1 years</option>
                                <option value="2-3" {{ request('experience') == '2-3' ? 'selected' : '' }}>2 - 3 years</option>
                                <option value="3-5" {{ request('experience') == '3-5' ? 'selected' : '' }}>3 - 5 years</option>
                                <option value="5-7" {{ request('experience') == '5-7' ? 'selected' : '' }}>5 - 7 years</option>
                                <option value="7-10" {{ request('experience') == '7-10' ? 'selected' : '' }}>7 - 10 years</option>
                                <option value="10+" {{ request('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                            </select>
                        </div>

                        <!-- Expected Salary -->
                        <div class="input-group">
                            <label>Expected Salary</label>
                            <select class="form-control" name="salary">
                                <option value="">All Salary Ranges</option>
                                <option value="0-1999" {{ request('salary') == '0-1999' ? 'selected' : '' }}>0 - 1,999</option>
                                <option value="2000-3999" {{ request('salary') == '2000-3999' ? 'selected' : '' }}>2,000 - 3,999</option>
                                <option value="4000-5999" {{ request('salary') == '4000-5999' ? 'selected' : '' }}>4,000 - 5,999</option>
                                <option value="6000-9999" {{ request('salary') == '6000-9999' ? 'selected' : '' }}>6,000 - 9,999</option>
                                <option value="10000-14999" {{ request('salary') == '10000-14999' ? 'selected' : '' }}>10,000 - 14,999</option>
                                <option value="15000+" {{ request('salary') == '15000+' ? 'selected' : '' }}>15,000+</option>
                            </select>
                        </div>

                        <!-- Country -->
                        <div class="input-group">
                            <label>Country</label>
                            <select class="form-control" name="country" id="countrySelect">
                                <option value="">All Countries</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" {{ request('country') == $country->name ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City -->
                        <div class="input-group">
                            <label>City</label>
                            <select class="form-control" name="city" id="citySelect">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->name }}" {{ request('city') == $city->name ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nationality -->
                        <div class="input-group">
                            <label>Nationality</label>
                            <select class="form-control" name="nationality">
                                <option value="">All Nationalities</option>
                                <option value="UAE" {{ request('nationality') == 'UAE' ? 'selected' : '' }}>UAE</option>
                                <option value="India" {{ request('nationality') == 'India' ? 'selected' : '' }}>India</option>
                                <option value="Pakistan" {{ request('nationality') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                <option value="Egypt" {{ request('nationality') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                <option value="USA" {{ request('nationality') == 'USA' ? 'selected' : '' }}>USA</option>
                                <option value="UK" {{ request('nationality') == 'UK' ? 'selected' : '' }}>UK</option>
                                <option value="Bangladesh" {{ request('nationality') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                <option value="Philippines" {{ request('nationality') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                <option value="Sri Lanka" {{ request('nationality') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                            </select>
                        </div>

                        <div class="input-group justify-content-center">
                            <input type="submit" value="Apply Filter" class="apply_btn">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 fadeInLeft">
                <div class="cate_list m-0">
                    
                  

                    <!-- Featured Resumes Section -->
                    @if($featuredCandidates && $featuredCandidates->count() > 0)
                    <section style="margin-top: 0; margin-bottom: 60px;">
                        <div style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                <div>
                                    <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">Featured Resumes</h2>
                                    <p class="section-sub" style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.5;">Connect with top talent ready for their next opportunity</p>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <a href="{{ route('candidates.index') }}" style="display: flex; align-items: center; gap: 6px; color: #4b5563; font-size: 15px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#4b5563';">
                                        View All Candidates
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; width: 100%; margin: 0; align-items: stretch;">
                            @foreach($featuredCandidates as $candidate)
                            @php
                                $profile = $candidate->seekerProfile;
                                $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                                    $nameParts = explode(' ', $displayName);
                                    $initials = strtoupper(($nameParts[0][0] ?? '') . ($nameParts[1][0] ?? $nameParts[0][1] ?? ''));
                                $rawPhoto = $profile->profile_picture ?? null;
                                $hasImage = false;
                                $avatarPath = null;

                                if ($rawPhoto) {
                                    if (\Illuminate\Support\Str::startsWith($rawPhoto, ['http://', 'https://'])) {
                                        $hasImage = true;
                                        $avatarPath = $rawPhoto;
                                    } else {
                                        $normalized = ltrim($rawPhoto, '/');
                                        if (file_exists(public_path($normalized))) {
                                            $hasImage = true;
                                            $avatarPath = asset($normalized);
                                        }
                                    }
                                }
                                
                                $skills = [];
                                if($profile && $profile->skills) {
                                    $skillsData = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
                                    if(is_array($skillsData)) {
                                        $skills = array_slice($skillsData, 0, 3);
                                    }
                                }
                            @endphp
                                <div class="cand" style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); text-align: center; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%; min-height: 380px;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                                    <!-- Avatar with Featured Star -->
                                    <div style="position: relative; display: inline-block; margin-bottom: 16px;">
                                        <div class="circle" style="width: 64px; height: 64px; border-radius: 50%; background: #f3f4f6; margin: auto; font-size: 20px; display: flex; justify-content: center; align-items: center; color: #000; font-weight: 700;">
                                    @if($hasImage && $avatarPath)
                                        <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                        <!-- Featured Star -->
                                        <div style="position: absolute; top: -4px; right: -4px; width: 24px; height: 24px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#ffffff" stroke="none">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Candidate Name -->
                                    <div class="cand-name" style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                                    
                                    <!-- Job Title -->
                                    <div class="cand-role" style="font-size: 14px; color: #6b7280; margin-bottom: 12px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                                    
                                    <!-- Location -->
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span>{{ $profile->city ?? 'UAE' }}{{ $profile->country ? ', ' . $profile->country : '' }}</span>
                                    </div>
                                    
                                    <!-- Skills Tags -->
                                @if(count($skills) > 0)
                                        <div class="cand-tags" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; margin-bottom: auto;">
                                    @foreach($skills as $skill)
                                                <span style="font-size: 12px; background: #f3f4f6; padding: 4px 10px; border-radius: 12px; color: #1a1a1a; font-weight: 500;">{{ $skill }}</span>
                                    @endforeach
                                </div>
                                    @else
                                        <div style="flex: 1;"></div>
                                @endif
                                    
                                    <!-- Experience and Rating -->
                                    <div class="cand-info" style="display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #6b7280; padding-top: 16px; border-top: 1px solid #e5e7eb; margin-top: auto;">
                                        <span style="font-weight: 500;">{{ $profile->experience_years ?? 'N/A' }} Years</span>
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="none">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span style="font-weight: 600; color: #1a1a1a;">4.9</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- HR Separator -->
                    <hr style="width: 90%; max-width: 1200px; margin: 60px auto; border: none; border-top: 1px solid #e5e7eb;">
                    @endif

                    <!-- Recommended Resumes Section -->
                    @if($recommendedCandidates && $recommendedCandidates->count() > 0)
                    @php
                        $featuredCandidateIds = $featuredCandidates ? $featuredCandidates->pluck('id')->toArray() : [];
                    @endphp
                    <section style="margin-top: 0; margin-bottom: 60px;">
                        <div style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                <div>
                                    <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">Recommended Resumes</h2>
                                    <p class="section-sub" style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.5;">Discover more talented professionals</p>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <a href="{{ route('candidates.index') }}" style="display: flex; align-items: center; gap: 6px; color: #4b5563; font-size: 15px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#4b5563';">
                                        View All Candidates
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; width: 100%; margin: 0; align-items: stretch;">
                        @foreach($recommendedCandidates as $candidate)
                        @php
                            if (in_array($candidate->id, $featuredCandidateIds)) {
                                continue;
                            }
                            $isCurrentlyFeatured = $candidate->seekerProfile && 
                                $candidate->seekerProfile->is_featured && 
                                ($candidate->seekerProfile->featured_expires_at === null || 
                                 $candidate->seekerProfile->featured_expires_at > now());
                            if ($isCurrentlyFeatured) {
                                continue;
                            }
                                    
                            $profile = $candidate->seekerProfile;
                            $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                                    $nameParts = explode(' ', $displayName);
                                    $initials = strtoupper(($nameParts[0][0] ?? '') . ($nameParts[1][0] ?? $nameParts[0][1] ?? ''));
                            $rawPhoto = $profile->profile_picture ?? null;
                            $hasImage = false;
                            $avatarPath = null;

                            if ($rawPhoto) {
                                if (\Illuminate\Support\Str::startsWith($rawPhoto, ['http://', 'https://'])) {
                                    $hasImage = true;
                                    $avatarPath = $rawPhoto;
                                } else {
                                    $normalized = ltrim($rawPhoto, '/');
                                    if (file_exists(public_path($normalized))) {
                                        $hasImage = true;
                                        $avatarPath = asset($normalized);
                                    }
                                }
                            }
                            
                            $skills = [];
                            if($profile && $profile->skills) {
                                $skillsData = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
                                if(is_array($skillsData)) {
                                    $skills = array_slice($skillsData, 0, 3);
                                }
                            }
                        @endphp
                                <div class="cand" style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); text-align: center; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%; min-height: 380px;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                                    <!-- Avatar -->
                                    <div style="position: relative; display: inline-block; margin-bottom: 16px;">
                                        <div class="circle" style="width: 64px; height: 64px; border-radius: 50%; background: #f3f4f6; margin: auto; font-size: 20px; display: flex; justify-content: center; align-items: center; color: #000; font-weight: 700;">
                                @if($hasImage && $avatarPath)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                                    </div>
                                    
                                    <!-- Candidate Name -->
                                    <div class="cand-name" style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                                    
                                    <!-- Job Title -->
                                    <div class="cand-role" style="font-size: 14px; color: #6b7280; margin-bottom: 12px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                                    
                                    <!-- Location -->
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span>{{ $profile->city ?? 'UAE' }}{{ $profile->country ? ', ' . $profile->country : '' }}</span>
                                    </div>
                                    
                                    <!-- Skills Tags -->
                            @if(count($skills) > 0)
                                        <div class="cand-tags" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; margin-bottom: auto;">
                                @foreach($skills as $skill)
                                                <span style="font-size: 12px; background: #f3f4f6; padding: 4px 10px; border-radius: 12px; color: #1a1a1a; font-weight: 500;">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div style="flex: 1;"></div>
                                    @endif
                                    
                                    <!-- Experience and Rating -->
                                    <div class="cand-info" style="display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #6b7280; padding-top: 16px; border-top: 1px solid #e5e7eb; margin-top: auto;">
                                        <span style="font-weight: 500;">{{ $profile->experience_years ?? 'N/A' }} Years</span>
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="none">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span style="font-weight: 600; color: #1a1a1a;">4.9</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- HR Separator -->
                    <hr style="width: 90%; max-width: 1200px; margin: 60px auto; border: none; border-top: 1px solid #e5e7eb;">
                    @endif

                    <!-- All Candidates Listing -->
                    <section style="margin-top: 0; margin-bottom: 60px;">
                        <div style="width: 100%;">
                            <div style="margin-bottom: 30px;">
                            <strong style="font-size: 16px; color: #000;">{{ $candidates->total() }} candidates found</strong>
                        </div>
                            <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; width: 100%; margin: 0; align-items: stretch;">
                        @forelse($candidates as $candidate)
                        @php
                            $profile = $candidate->seekerProfile;
                            $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                                    $nameParts = explode(' ', $displayName);
                                    $initials = strtoupper(($nameParts[0][0] ?? '') . ($nameParts[1][0] ?? $nameParts[0][1] ?? ''));
                            $rawPhoto = $profile->profile_picture ?? null;
                            $hasImage = false;
                            $avatarPath = null;

                            if ($rawPhoto) {
                                if (\Illuminate\Support\Str::startsWith($rawPhoto, ['http://', 'https://'])) {
                                    $hasImage = true;
                                    $avatarPath = $rawPhoto;
                                } else {
                                    $normalized = ltrim($rawPhoto, '/');
                                    if (file_exists(public_path($normalized))) {
                                        $hasImage = true;
                                        $avatarPath = asset($normalized);
                                    }
                                }
                            }
                            
                            $skills = [];
                            if($profile && $profile->skills) {
                                $skillsData = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
                                if(is_array($skillsData)) {
                                    $skills = array_slice($skillsData, 0, 3);
                                }
                            }
                        @endphp
                                <div class="cand" style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); text-align: center; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%; min-height: 380px;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                                    <!-- Avatar -->
                                    <div style="position: relative; display: inline-block; margin-bottom: 16px;">
                                        <div class="circle" style="width: 64px; height: 64px; border-radius: 50%; background: #f3f4f6; margin: auto; font-size: 20px; display: flex; justify-content: center; align-items: center; color: #000; font-weight: 700;">
                                @if($hasImage && $avatarPath)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                                    </div>
                                    
                                    <!-- Candidate Name -->
                                    <div class="cand-name" style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                                    
                                    <!-- Job Title -->
                                    <div class="cand-role" style="font-size: 14px; color: #6b7280; margin-bottom: 12px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                                    
                                    <!-- Location -->
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span>{{ $profile->city ?? 'UAE' }}{{ $profile->country ? ', ' . $profile->country : '' }}</span>
                                    </div>
                                    
                                    <!-- Skills Tags -->
                            @if(count($skills) > 0)
                                        <div class="cand-tags" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; margin-bottom: auto;">
                                @foreach($skills as $skill)
                                                <span style="font-size: 12px; background: #f3f4f6; padding: 4px 10px; border-radius: 12px; color: #1a1a1a; font-weight: 500;">{{ $skill }}</span>
                                @endforeach
                            </div>
                                    @else
                                        <div style="flex: 1;"></div>
                            @endif
                                    
                                    <!-- Experience and Rating -->
                                    <div class="cand-info" style="display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #6b7280; padding-top: 16px; border-top: 1px solid #e5e7eb; margin-top: auto;">
                                        <span style="font-weight: 500;">{{ $profile->experience_years ?? 'N/A' }} Years</span>
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="none">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span style="font-weight: 600; color: #1a1a1a;">4.9</span>
                                        </div>
                            </div>
                        </div>
                        @empty
                                <div class="no-candidates" style="text-align: center; padding: 60px 20px; color: #6c757d; grid-column: 1 / -1;">
                            <h4>No candidates found</h4>
                            <p>No candidates match your search criteria. Try adjusting your filters.</p>
                        </div>
                        @endforelse
                    </div>
                        </div>
                    </section>

                    <!-- Pagination -->
                    @if($candidates->hasPages())
                    <div style="width: 100%; margin-top: 40px; display: flex; justify-content: center;">
                        {{ $candidates->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Dynamic city loading based on country selection
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('countrySelect');
    const citySelect = document.getElementById('citySelect');
    
    if (countrySelect && citySelect) {
        countrySelect.addEventListener('change', function() {
            const country = this.value;
            citySelect.innerHTML = '<option value="">Loading...</option>';
            citySelect.disabled = true;
            
            if (country) {
                fetch(`{{ url('/api/cities') }}/${encodeURIComponent(country)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        citySelect.innerHTML = '<option value="">All Cities</option>';
                        if (data.success && data.cities && Array.isArray(data.cities)) {
                            data.cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        }
                        citySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                        citySelect.innerHTML = '<option value="">All Cities</option>';
                        citySelect.disabled = false;
                    });
            } else {
                citySelect.innerHTML = '<option value="">All Cities</option>';
                citySelect.disabled = false;
            }
        });
    }
    
    // Also handle mobile filters
    const mobileCountrySelect = document.getElementById('mobileCountry');
    const mobileCitySelect = document.getElementById('mobileCity');
    
    if (mobileCountrySelect && mobileCitySelect) {
        mobileCountrySelect.addEventListener('change', function() {
            const country = this.value;
            mobileCitySelect.innerHTML = '<option value="">Loading...</option>';
            mobileCitySelect.disabled = true;
            
            if (country) {
                fetch(`{{ url('/api/cities') }}/${encodeURIComponent(country)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        mobileCitySelect.innerHTML = '<option value="">All Cities</option>';
                        if (data.success && data.cities && Array.isArray(data.cities)) {
                            data.cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name;
                                option.textContent = city.name;
                                mobileCitySelect.appendChild(option);
                            });
                        }
                        mobileCitySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                        mobileCitySelect.innerHTML = '<option value="">All Cities</option>';
                        mobileCitySelect.disabled = false;
                    });
            } else {
                mobileCitySelect.innerHTML = '<option value="">All Cities</option>';
                mobileCitySelect.disabled = false;
            }
        });
    }
});
</script>
@endsection
