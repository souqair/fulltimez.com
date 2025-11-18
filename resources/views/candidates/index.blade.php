@extends('layouts.app')

@section('title', 'Candidates')

@section('content')
<section class="breadcrumb-section">
    <div class="container-auto">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="page-title">
                    <h1>Candidates</h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Candidates</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="category-wrap innerseeker popular-items mt-5">
    <div class="container">
        <div class="main_title">Browse Candidates</div>
        
        @if($featuredCandidates && $featuredCandidates->count() > 0)
        <div class="featured-jobs-section-wrapper">
            <div class="section-title">
                <h2>Featured Resumes</h2>
            </div>
            <div class="featured-jobs-grid row g-4">
                @foreach($featuredCandidates as $candidate)
                @php
                    $profile = $candidate->seekerProfile;
                    $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                    $initial = strtoupper(mb_substr($displayName, 0, 1));
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
                @endphp
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="featured-job-card">
                        <div class="job-card-header">
                            <div class="company-header">
                                <div class="company-logo">
                                    @if($hasImage)
                                        <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #2772e8; color: #ffffff; font-weight: 700; font-size: 18px; border-radius: 8px;">
                                            {{ $initial }}
                                        </div>
                                    @endif
                                </div>
                                <div class="company-name">
                                    <h3>{{ $displayName }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-body">
                            <div class="job-title">
                                <a href="{{ route('candidates.show', $candidate->id) }}">{{ $profile->current_position ?? 'Job Seeker' }}</a>
                            </div>
                            <div class="job-meta">
                                <div class="category-badge-top">Featured</div>
                                <div class="meta-badge">
                                    Experience: <span>{{ $profile->experience_years ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-badge">
                                    Location: <span>{{ $profile->city ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="location-info">
                                <img src="{{ asset('images/location.svg') }}" alt="location">
                                <span>{{ $profile->city ?? 'N/A' }}, {{ $profile->country ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="job-card-footer">
                            <div class="price-ad">
                                <p>
                                    @php
                                        $salary = $profile->expected_salary ?? 'Negotiable';
                                        if (preg_match('/(\d+[\d,]+)/', $salary, $matches)) {
                                            $amount = str_replace(',', '', $matches[1]);
                                            echo '<span class="price-amount">AED ' . number_format((float)$amount) . '</span>';
                                        } else {
                                            echo '<span class="price-negotiable">' . $salary . '</span>';
                                        }
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($recommendedCandidates && $recommendedCandidates->count() > 0)
        <div class="mt-4 mb-3 d-flex justify-content-between align-items-center">
            <strong>Recommended Resumes</strong>
        </div>
        <div class="recommended-jobs-grid row g-4">
            @foreach($recommendedCandidates as $candidate)
            @php
                $profile = $candidate->seekerProfile;
                $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                $initial = strtoupper(mb_substr($displayName, 0, 1));
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
            @endphp
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="featured-job-card">
                    <div class="job-card-header">
                        <div class="company-header">
                            <div class="company-logo">
                                @if($hasImage)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #2772e8; color: #ffffff; font-weight: 700; font-size: 18px; border-radius: 8px;">
                                        {{ $initial }}
                                    </div>
                                @endif
                            </div>
                            <div class="company-name">
                                <h3>{{ $displayName }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="job-card-body">
                        <div class="job-title">
                            <a href="{{ route('candidates.show', $candidate->id) }}">{{ $profile->current_position ?? 'Job Seeker' }}</a>
                        </div>
                        <div class="job-meta">
                            <div class="category-badge-top">Recommended</div>
                            <div class="meta-badge">
                                Experience: <span>{{ $profile->experience_years ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-badge">
                                Location: <span>{{ $profile->city ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="location-info">
                            <img src="{{ asset('images/location.svg') }}" alt="location">
                            <span>{{ $profile->city ?? 'N/A' }}, {{ $profile->country ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="job-card-footer">
                        <div class="price-ad">
                            <p>
                                @php
                                    $salary = $profile->expected_salary ?? 'Negotiable';
                                    if (preg_match('/(\d+[\d,]+)/', $salary, $matches)) {
                                        $amount = str_replace(',', '', $matches[1]);
                                        echo '<span class="price-amount">AED ' . number_format((float)$amount) . '</span>';
                                    } else {
                                        echo '<span class="price-negotiable">' . $salary . '</span>';
                                    }
                                @endphp
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 fadeInLeft">
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

            <!-- Candidates Grid -->
            <div class="col-lg-9 fadeInLeft">
                <div class="candidates-grid-wrapper">
                    <div class="mb-3">
                        <strong>{{ $candidates->total() }} candidates found</strong>
                    </div>
                    
                    <div class="candidates-grid">
                        @forelse($candidates as $candidate)
                        <div class="featured-candidate-card">
                            <!-- Featured Badge -->
                            <div class="featured-badge">
                                <i class="fas fa-star"></i>
                            </div>
                            
                            <!-- Favorite Icon -->
                            <div class="favorite-icon">
                                <i class="far fa-heart"></i>
                            </div>
                            
                            <!-- Profile Picture -->
                            <div class="candidate-profile-picture">
                                @if($candidate->seekerProfile && $candidate->seekerProfile->profile_picture)
                                    <img src="{{ asset($candidate->seekerProfile->profile_picture) }}" alt="{{ $candidate->seekerProfile->full_name ?? $candidate->name }}">
                                @else
                                    <div class="candidate-avatar-default">
                                        {{ strtoupper(substr($candidate->seekerProfile->full_name ?? $candidate->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Candidate Info -->
                            <div class="candidate-card-body">
                                <h5 class="candidate-name">{{ $candidate->seekerProfile->full_name ?? $candidate->name }}</h5>
                                
                                <!-- Rate -->
                                <div class="candidate-rate">
                                    @php
                                        $salary = $candidate->seekerProfile->expected_salary ?? 'Negotiable';
                                        // Try to extract number from salary string
                                        if (preg_match('/(\d+[\d,]+)/', $salary, $matches)) {
                                            $amount = str_replace(',', '', $matches[1]);
                                            // Format as currency
                                            echo 'AED ' . number_format((float)$amount);
                                        } else {
                                            echo $salary;
                                        }
                                    @endphp
                                </div>
                                
                                <!-- Profession -->
                                <p class="candidate-profession">{{ $candidate->seekerProfile->current_position ?? 'Job Seeker' }}</p>
                                
                                <!-- Location -->
                                <div class="candidate-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $candidate->seekerProfile->city ?? 'UAE' }}, {{ $candidate->seekerProfile->country ?? 'UAE' }}</span>
                                </div>
                                
                                <!-- Rating -->
                                <div class="candidate-rating">
                                    @php
                                        $rating = 4.5; // Default rating, you can calculate this based on reviews if you have them
                                    @endphp
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-number">{{ number_format($rating, 1) }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="candidate-card-footer">
                                <a href="{{ route('candidates.show', $candidate->id) }}" class="btn-view-profile">Profile</a>
                                <a href="#" class="btn-hire-me">Hire Me</a>
                            </div>
                        </div>
                        @empty
                        <div class="no-candidates">
                            <h4>No candidates found</h4>
                            <p>No candidates match your search criteria. Try adjusting your filters.</p>
                        </div>
                        @endforelse
                    </div>

                    @if($candidates->hasPages())
                    <div class="simple-pagination">
                        {{ $candidates->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Featured Candidate Card Styles */
.candidates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    padding: 20px 0;
}

.featured-candidate-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.featured-candidate-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.featured-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    background: #fbbf24;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
}

.featured-badge i {
    color: #ffffff;
    font-size: 14px;
}

.favorite-icon {
    position: absolute;
    top: 16px;
    right: 50px;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    cursor: pointer;
    transition: all 0.3s ease;
}

.favorite-icon:hover {
    background: #fff;
    transform: scale(1.1);
}

.favorite-icon i {
    color: #9ca3af;
    font-size: 16px;
}

.favorite-icon:hover i {
    color: #ef4444;
}

.candidate-profile-picture {
    padding: 30px 20px 20px;
    display: flex;
    justify-content: center;
    background: #f8f9fa;
}

.candidate-profile-picture img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.candidate-avatar-default {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: #ffffff;
    border: 4px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.candidate-card-body {
    padding: 0 20px 20px;
    text-align: center;
    flex: 1;
}

.candidate-name {
    font-size: 18px;
    color: #2d3748;
    margin: 14px 0 10px 0 !important;
    font-weight: 600;
}

.candidate-rate {
    font-size: 16px;
    color: #22c55e;
    margin: 0 0 8px 0;
    font-weight: 600;
}

.candidate-profession {
    font-size: 14px;
    color: #4a5568;
    margin: 0 0 12px 0;
}

.candidate-location {
    font-size: 14px;
    color: #000;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.candidate-location i {
    font-size: 12px;
}

.candidate-rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 0 0 20px 0;
}

.rating-stars {
    display: flex;
    gap: 2px;
}

.rating-stars i {
    font-size: 14px;
    color: #fbbf24;
}

.rating-number {
    background: #22c55e;
    color: #ffffff;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.candidate-card-footer {
    padding: 16px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 8px;
}

.btn-view-profile {
    flex: 1;
    background: #2d3748;
    color: #ffffff;
    text-align: center;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-profile:hover {
    background: #1a202c;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(45, 55, 72, 0.2);
    text-decoration: none;
}

.btn-hire-me {
    flex: 1;
    background: #e5e7eb;
    color: #4a5568;
    text-align: center;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-hire-me:hover {
    background: #d1d5db;
    color: #2d3748;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.no-candidates {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
    grid-column: 1 / -1;
}

.simple-pagination {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.simple-pagination .pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.simple-pagination .pagination li {
    display: inline-block;
}

.simple-pagination .pagination .page-link {
    display: block;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    color: #007bff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.simple-pagination .pagination .page-link:hover {
    background-color: #e9ecef;
    color: #0056b3;
    text-decoration: none;
}

.simple-pagination .pagination .active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.simple-pagination .pagination .disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

@media (max-width: 1200px) {
    .candidates-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .candidates-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
    
    .candidate-profile-picture img,
    .candidate-avatar-default {
        width: 100px;
        height: 100px;
        font-size: 40px;
    }
    
    .candidate-name {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .candidates-grid {
        grid-template-columns: 1fr;
    }
}

/* Featured & Recommended Resumes Sections - Same as Browse Jobs */
.featured-jobs-section-wrapper {
    background: transparent;
    margin-bottom: 32px;
}

.featured-jobs-section-wrapper .section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.featured-jobs-section-wrapper .section-title h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.featured-jobs-grid {
    padding: 20px 0 !important;
}

.featured-job-card {
    background: #ffffff !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    cursor: pointer !important;
}

.featured-job-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
    transform: translateY(-4px) !important;
    border-color: #cbd5e1 !important;
}

.job-card-header {
    padding: 14px 16px 12px !important;
    background: #2772e8 !important;
    position: relative !important;
    border-radius: 12px 12px 0 0 !important;
}

.company-header {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    width: 100% !important;
}

.company-logo {
    width: 40px !important;
    height: 40px !important;
    border-radius: 8px !important;
    background: #ffffff !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
    overflow: hidden !important;
}

.company-logo img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.company-name {
    flex: 1 !important;
    min-width: 0 !important;
}

.company-name h3 {
    font-size: 13px !important;
    color: #ffffff !important;
    margin: 0 !important;
    line-height: 1.4 !important;
    word-wrap: break-word !important;
    letter-spacing: 0.2px !important;
    font-weight: 600 !important;
}

.job-card-body {
    padding: 14px 16px 12px !important;
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    background: #ffffff !important;
    position: relative !important;
}

.job-title {
    margin-bottom: 10px !important;
}

.job-title a {
    font-size: 15px !important;
    color: #111827 !important;
    text-decoration: none !important;
    line-height: 1.5 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    transition: color 0.2s ease !important;
    letter-spacing: -0.2px !important;
    margin-bottom: 0 !important;
    font-weight: 600 !important;
}

.job-title a:hover {
    color: #2772e8 !important;
    text-decoration: none !important;
}

.job-meta {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 5px !important;
    margin-bottom: 10px !important;
}

.category-badge-top {
    background: #2772e8 !important;
    color: #ffffff !important;
    font-size: 10px !important;
    padding: 5px 10px !important;
    border-radius: 5px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.3px !important;
    border: none !important;
    display: inline-block !important;
    font-weight: 600 !important;
}

.meta-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    padding: 4px 10px !important;
    background: #f9fafb !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 5px !important;
    font-size: 10px !important;
    color: #6b7280 !important;
    transition: all 0.2s ease !important;
}

.meta-badge span {
    font-weight: 600 !important;
    color: #374151 !important;
}

.location-info {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    color: #6b7280 !important;
    font-size: 11px !important;
    margin-bottom: 12px !important;
}

.location-info img {
    width: 14px !important;
    height: 14px !important;
    opacity: 0.7 !important;
}

.location-info span {
    font-size: 11px !important;
    color: #6b7280 !important;
    font-weight: 500 !important;
}

.job-card-footer {
    padding: 12px 16px 14px !important;
    border-top: 1px solid #f3f4f6 !important;
    margin-top: auto !important;
    background: #ffffff !important;
    flex-shrink: 0 !important;
    position: relative !important;
}

.price-ad {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 5px !important;
    flex-wrap: nowrap !important;
}

.price-ad p {
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
    gap: 4px !important;
    font-size: 14px !important;
    color: #059669 !important;
    line-height: 1.3 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    font-weight: 700 !important;
}

.price-ad p span.price-amount {
    font-size: 14px !important;
    color: #374151 !important;
    white-space: nowrap !important;
    font-weight: 700 !important;
}

.price-ad p span.price-negotiable {
    font-size: 14px !important;
    color: #007bff !important;
    white-space: nowrap !important;
    font-weight: 600 !important;
}

.featured-jobs-grid,
.recommended-jobs-grid {
    margin-bottom: 36px;
    row-gap: 24px;
}

.featured-jobs-grid .col-lg-4,
.featured-jobs-grid .col-md-6,
.recommended-jobs-grid .col-lg-4,
.recommended-jobs-grid .col-md-6 {
    display: flex;
}

.featured-jobs-grid .featured-job-card,
.recommended-jobs-grid .featured-job-card {
    width: 100%;
}
</style>

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
                // Clear cities when no country selected
                citySelect.innerHTML = '<option value="">All Cities</option>';
                citySelect.disabled = false;
            }
        });
    }
});
</script>
@endsection
