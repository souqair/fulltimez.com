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

/* Mobile Responsive Styles */
@media (max-width: 991px) {
    /* Hide desktop filters on mobile */
    .col-lg-3 {
        display: none !important;
    }
    
    /* Full width for candidates column on mobile */
    .col-lg-9 {
        width: 100% !important;
        max-width: 100% !important;
        margin-top: 0 !important;
        padding: 0 !important;
    }
    
    /* Container adjustments */
    section.category-wrap > div {
        width: 95% !important;
        padding: 0 15px !important;
    }
    
    /* Breadcrumb mobile */
    div[style*="width: 90%"] {
        width: 95% !important;
        padding: 0 15px !important;
        margin: 20px auto 15px !important;
    }
    
    /* Section titles mobile */
    h2.section-title {
        margin-left: 0 !important;
        font-size: 20px !important;
        padding: 0 15px !important;
    }
    
    /* Candidates grid mobile */
    .candidates-grid {
        grid-template-columns: 1fr !important;
        width: 100% !important;
        gap: 20px !important;
        padding: 0 !important;
    }
    
    /* Desktop - 3 columns for wider cards */
    @media (min-width: 992px) {
        .candidates-grid[style*="grid-template-columns: repeat(3"] {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    
    /* Row adjustments */
    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}

@media (max-width: 768px) {
    .cate_list {
        padding: 0px 0px !important;
    }
    
    .candidates-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        padding: 0 !important;
    }
    
    .candidates-grid-wrapper {
        width: 100% !important;
        padding: 0 !important;
    }
    
    .candidates-grid-wrapper .mb-3 {
        margin-left: 0 !important;
        padding: 0 15px !important;
    }
}

@media (max-width: 576px) {
    /* Extra small devices */
    section.category-wrap > div {
        width: 100% !important;
        padding: 0 10px !important;
    }
    
    div[style*="width: 90%"] {
        width: 100% !important;
        padding: 0 10px !important;
        margin: 15px auto 10px !important;
    }
    
    h2.section-title {
        font-size: 18px !important;
        padding: 0 10px !important;
    }
    
    .candidates-grid {
        gap: 20px !important;
        padding: 0 !important;
    }
    
    .cand {
        padding: 20px !important;
        margin: 0 !important;
    }
}
</style>
@endpush

@section('content')
<!-- Simple Breadcrumb -->
<div style="width: 90%; margin: 40px auto 20px; padding: 0 20px;">
    <nav style="font-size: 13px; color: #666;">
        <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Home</a> / 
        <span style="color: #000;">Candidates</span>
    </nav>
</div>

<section class="category-wrap innerseeker popular-items mt-5">
    <div class="" style="max-width: 100%; width: 90%; margin: 0 auto; padding: 0 20px;">
        
        <div class="row">
            <!-- Sidebar Filters -->
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
                    @if($featuredCandidates && $featuredCandidates->count() > 0)
                    <h2 class="section-title" style="font-size: 24px; font-weight: 700; margin-left: 60px; margin-bottom: 10px; margin-top: 20px; color: #000;">Featured Resumes</h2>
                    <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 90%; margin: auto; padding: 50px 0;">
                            @foreach($featuredCandidates as $candidate)
                            @php
                                $profile = $candidate->seekerProfile;
                                $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                                $initials = strtoupper(mb_substr($displayName, 0, 1) . (mb_substr($displayName, strpos($displayName, ' ') + 1, 1) ?? ''));
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
                            <div class="cand" style="border: 1px solid #eee; border-radius: 16px; padding: 25px 0; text-align: center; cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                                <div class="circle" style="width: 50px; height: 50px; border-radius: 50%; background: #f5f5f5; margin: auto; font-size: 18px; display: flex; justify-content: center; align-items: center; color: #666; font-weight: 600;">
                                    @if($hasImage && $avatarPath)
                                        <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="cand-name" style="margin-top: 10px; font-size: 14px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                                <div class="cand-role" style="font-size: 11px; color: #666; margin-bottom: 10px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                                @if(count($skills) > 0)
                                <div class="cand-tags" style="margin-bottom: 10px;">
                                    @foreach($skills as $skill)
                                        <span style="font-size: 10px; background: #eee; padding: 3px 7px; margin: 2px; border-radius: 6px; display: inline-block; color: #444;">{{ $skill }}</span>
                                    @endforeach
                                </div>
                                @endif
                                <div class="cand-info" style="font-size: 11px; color: #666; margin-top: 10px;">
                                    {{ $profile->experience_years ?? 'N/A' }} Years • ⭐ 4.9
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($recommendedCandidates && $recommendedCandidates->count() > 0)
                    @php
                        // Get Featured candidate IDs to exclude from Recommended display
                        $featuredCandidateIds = $featuredCandidates ? $featuredCandidates->pluck('id')->toArray() : [];
                    @endphp
                    <h2 class="section-title" style="font-size: 24px; font-weight: 700; margin-left: 60px; margin-bottom: 10px; margin-top: 20px; color: #000;">Recommended Resumes</h2>
                    <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 90%; margin: auto; padding: 50px 0;">
                        @foreach($recommendedCandidates as $candidate)
                        @php
                            // Skip if candidate is in Featured section
                            if (in_array($candidate->id, $featuredCandidateIds)) {
                                continue;
                            }
                            // Also check if candidate is currently featured (double check)
                            $isCurrentlyFeatured = $candidate->seekerProfile && 
                                $candidate->seekerProfile->is_featured && 
                                ($candidate->seekerProfile->featured_expires_at === null || 
                                 $candidate->seekerProfile->featured_expires_at > now());
                            if ($isCurrentlyFeatured) {
                                continue;
                            }
                        @endphp
                        @php
                            $profile = $candidate->seekerProfile;
                            $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                            $initials = strtoupper(mb_substr($displayName, 0, 1) . (mb_substr($displayName, strpos($displayName, ' ') + 1, 1) ?? ''));
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
                        <div class="cand" style="border: 1px solid #eee; border-radius: 16px; padding: 25px 0; text-align: center; cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                            <div class="circle" style="width: 50px; height: 50px; border-radius: 50%; background: #f5f5f5; margin: auto; font-size: 18px; display: flex; justify-content: center; align-items: center; color: #666; font-weight: 600;">
                                @if($hasImage && $avatarPath)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div class="cand-name" style="margin-top: 10px; font-size: 14px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                            <div class="cand-role" style="font-size: 11px; color: #666; margin-bottom: 10px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                            @if(count($skills) > 0)
                            <div class="cand-tags" style="margin-bottom: 10px;">
                                @foreach($skills as $skill)
                                    <span style="font-size: 10px; background: #eee; padding: 3px 7px; margin: 2px; border-radius: 6px; display: inline-block; color: #444;">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @endif
                            <div class="cand-info" style="font-size: 11px; color: #666; margin-top: 10px;">
                                {{ $profile->experience_years ?? 'N/A' }} Years • ⭐ 4.9
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="candidates-grid-wrapper">
                        <div class="mb-3" style="margin-left: 60px;">
                            <strong style="font-size: 16px; color: #000;">{{ $candidates->total() }} candidates found</strong>
                        </div>
                    
                    <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 90%; margin: auto; padding: 50px 0;">
                        @forelse($candidates as $candidate)
                        @php
                            $profile = $candidate->seekerProfile;
                            $displayName = $profile->full_name ?? $candidate->name ?? 'Candidate';
                            $initials = strtoupper(mb_substr($displayName, 0, 1) . (mb_substr($displayName, strpos($displayName, ' ') + 1, 1) ?? ''));
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
                        <div class="cand" style="border: 1px solid #eee; border-radius: 16px; padding: 25px 0; text-align: center; cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
                            <div class="circle" style="width: 50px; height: 50px; border-radius: 50%; background: #f5f5f5; margin: auto; font-size: 18px; display: flex; justify-content: center; align-items: center; color: #666; font-weight: 600;">
                                @if($hasImage && $avatarPath)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div class="cand-name" style="margin-top: 10px; font-size: 14px; font-weight: 700; color: #000;">{{ $displayName }}</div>
                            <div class="cand-role" style="font-size: 11px; color: #666; margin-bottom: 10px;">{{ $profile->current_position ?? 'Job Seeker' }}</div>
                            @if(count($skills) > 0)
                            <div class="cand-tags" style="margin-bottom: 10px;">
                                @foreach($skills as $skill)
                                    <span style="font-size: 10px; background: #eee; padding: 3px 7px; margin: 2px; border-radius: 6px; display: inline-block; color: #444;">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @endif
                            <div class="cand-info" style="font-size: 11px; color: #666; margin-top: 10px;">
                                {{ $profile->experience_years ?? 'N/A' }} Years • ⭐ 4.9
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
    </div>
</section>

<style>
/* Simple Candidate Card Styles - Same as Home Page */
.cand {
    transition: all 0.3s ease;
}

.cand:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    transform: translateY(-2px);
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
