@extends('layouts.app')

@section('title', 'Browse Jobs')

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
    
    .jobs-grid {
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
    $filtersActive = request()->filled('posted_as')
        || request()->filled('location')
        || request()->filled('category')
        || request()->filled('education')
        || request()->filled('salary')
        || request()->filled('nationality')
        || request()->filled('title');
    $jobCount = $recommendedJobs->total();
@endphp

<section class="category-wrap innerseeker popular-items mt-5">
    <div style="width: 90%; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Mobile Search Filters -->
        <div class="mobile-search-wrapper d-lg-none">
            <details class="mobile-search-card" {{ $filtersActive ? 'open' : '' }}>
                <summary>
                    <span>Refine Search</span>
                    @if($jobCount)
                    <span class="summary-meta">{{ number_format($jobCount) }} jobs</span>
                    @endif
                </summary>
                <form action="{{ route('jobs.index') }}" method="GET">
                    <div>
                        <label for="mobileTitle">Job Title</label>
                        <input type="text" id="mobileTitle" name="title" class="form-control" placeholder="e.g. Sales Manager" value="{{ request('title') }}">
                    </div>
                    <div>
                        <label for="mobilePostedAs">Posted As</label>
                        <select id="mobilePostedAs" name="posted_as">
                            <option value="">All Posts</option>
                            <option value="featured" {{ request('posted_as') === 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="recommended" {{ request('posted_as') === 'recommended' ? 'selected' : '' }}>Recommended</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileLocation">Current Location</label>
                        <select id="mobileLocation" name="location">
                            <option value="">All Locations</option>
                            <option value="Dubai" {{ request('location') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                            <option value="Abu Dhabi" {{ request('location') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                            <option value="Sharjah" {{ request('location') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                            <option value="Ajman" {{ request('location') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                            <option value="RAK" {{ request('location') == 'RAK' ? 'selected' : '' }}>Ras Al Khaimah</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileCategory">Category</label>
                        <select id="mobileCategory" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="mobileEducation">Education</label>
                        <select id="mobileEducation" name="education">
                            <option value="">All Education Levels</option>
                            <option value="high-school" {{ request('education') == 'high-school' ? 'selected' : '' }}>High-School / Secondary</option>
                            <option value="bachelors" {{ request('education') == 'bachelors' ? 'selected' : '' }}>Bachelors Degree</option>
                            <option value="masters" {{ request('education') == 'masters' ? 'selected' : '' }}>Masters Degree</option>
                            <option value="phd" {{ request('education') == 'phd' ? 'selected' : '' }}>PhD</option>
                        </select>
                    </div>
                    <div>
                        <label for="mobileSalary">Desired Salary</label>
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
                        <label for="mobileNationality">Nationality</label>
                        <select id="mobileNationality" name="nationality">
                            <option value="">All Nationalities</option>
                            <option value="UAE" {{ request('nationality') == 'UAE' ? 'selected' : '' }}>UAE</option>
                            <option value="India" {{ request('nationality') == 'India' ? 'selected' : '' }}>India</option>
                            <option value="Pakistan" {{ request('nationality') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                            <option value="Egypt" {{ request('nationality') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                            <option value="USA" {{ request('nationality') == 'USA' ? 'selected' : '' }}>USA</option>
                            <option value="UK" {{ request('nationality') == 'UK' ? 'selected' : '' }}>UK</option>
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
                        <a href="{{ route('jobs.index') }}" class="reset-link">
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
                    <form action="{{ route('jobs.index') }}" method="GET">
                        <div class="input-group">
                            <label>Posted as</label>
                            <select class="form-control" name="posted_as">
                                <option value="">All Posts</option>
                                <option value="featured" {{ request('posted_as') === 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="recommended" {{ request('posted_as') === 'recommended' ? 'selected' : '' }}>Recommended</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Current Location</label> 
                            <select class="form-control" name="location"> 
                                <option value="">All Locations</option>
                                <option value="Dubai" {{ request('location') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                                <option value="Abu Dhabi" {{ request('location') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                                <option value="Sharjah" {{ request('location') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                                <option value="Ajman" {{ request('location') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                                <option value="RAK" {{ request('location') == 'RAK' ? 'selected' : '' }}>Ras Al Khaimah</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Category</label> 
                            <select class="form-control" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Education</label> 
                            <select class="form-control" name="education"> 
                                <option value="">All Education Levels</option>
                                <option value="high-school" {{ request('education') == 'high-school' ? 'selected' : '' }}>High-School / Secondary</option>
                                <option value="bachelors" {{ request('education') == 'bachelors' ? 'selected' : '' }}>Bachelors Degree</option>
                                <option value="masters" {{ request('education') == 'masters' ? 'selected' : '' }}>Masters Degree</option>
                                <option value="phd" {{ request('education') == 'phd' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Desired Salary</label> 
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
                    
                   

                    <!-- Featured Jobs Section -->
                    @if($featuredJobs->count())
                    <section style="margin-top: 0; margin-bottom: 60px;">
                        <div style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                <div>
                                    <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">Featured Jobs</h2>
                                    <p class="section-sub" style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.5;">Discover exciting opportunities from top employers</p>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <a href="{{ route('jobs.index') }}" style="display: flex; align-items: center; gap: 6px; color: #4b5563; font-size: 15px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#4b5563';">
                                        Browse All Jobs
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 100%; margin: 0;">
                                @foreach($featuredJobs as $job)
                                <div class="job-card" style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('jobs.show', $job->slug) }}'">
                                    <div class="jc-top" style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; position: relative;">
                                        <!-- Circular Document Icon -->
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #1a1a1a;">
                                                <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <!-- Job Title and Company -->
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="jc-title" style="font-size: 18px; font-weight: 700; margin-bottom: 4px; color: #1a1a1a; line-height: 1.3;">
                                                <a href="{{ route('jobs.show', $job->slug) }}" style="color: #1a1a1a; text-decoration: none;">{{ $job->title }}</a>
                                            </div>
                                            <div class="jc-company" style="font-size: 14px; color: #1a1a1a; margin-bottom: 0;">
                                                {{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}
                                            </div>
                                        </div>
                                        <!-- Category Tag (Top Right) -->
                                        <div class="jc-tag" style="position: absolute; top: 0; right: 0; font-size: 12px; background: #f3f4f6; padding: 6px 12px; border-radius: 20px; color: #1a1a1a; white-space: nowrap; font-weight: 500;">
                                            {{ optional($job->category)->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <!-- Location -->
                                    <div class="jc-location" style="display: flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 12px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;">
                                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $job->location_city }}{{ $job->location_country ? ', ' . $job->location_country : '' }}</span>
                                    </div>
                                    <!-- Employment Type and Experience -->
                                    <div class="jc-employment" style="display: flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }} • {{ $job->experience_years ?? 'N/A' }} Years Experience</span>
                                    </div>
                                    <!-- Separator Line -->
                                    <div style="height: 1px; background: #e5e7eb; margin-bottom: 16px;"></div>
                                    <!-- Salary -->
                                    <div class="jc-salary" style="display: flex; align-items: baseline; justify-content: space-between;">
                                        <div style="font-size: 18px; font-weight: 700; color: #1a1a1a;">
                                            @if(!empty($job->salary_min) && !empty($job->salary_max))
                                                {{ $job->salary_currency ?? 'AED' }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }}
                                            @else
                                                <span style="color: #6b7280; font-weight: 500;">Negotiable</span>
                                            @endif
                                        </div>
                                        @if(!empty($job->salary_min) && !empty($job->salary_max))
                                        <div style="font-size: 14px; color: #6b7280; font-weight: 400;">
                                            / {{ ucfirst($job->salary_period ?? 'Monthly') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- HR Separator -->
                    <hr style="width: 90%; max-width: 1200px; margin: 60px auto; border: none; border-top: 1px solid #e5e7eb;">
                    @endif

                    <!-- Recommended Jobs Section -->
                    @php
                        $listHeading = ($postedAs ?? null) === 'featured' ? 'Featured Jobs' : 'Recommended Jobs';
                        $listSubheading = ($postedAs ?? null) === 'featured' ? 'Discover exciting opportunities from top employers' : 'Discover more opportunities tailored for you';
                    @endphp
                    <section style="margin-top: 0; margin-bottom: 60px;">
                        <div style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                <div>
                                    <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">{{ $listHeading }}</h2>
                                    <p class="section-sub" style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.5;">{{ $listSubheading }}</p>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <a href="{{ route('jobs.index') }}" style="display: flex; align-items: center; gap: 6px; color: #4b5563; font-size: 15px; font-weight: 500; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#4b5563';">
                                        Browse All Jobs
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 100%; margin: 0;">
                                @foreach($recommendedJobs as $job)
                                <div class="job-card" style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('jobs.show', $job->slug) }}'">
                                    <div class="jc-top" style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; position: relative;">
                                        <!-- Circular Document Icon -->
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #1a1a1a;">
                                                <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <!-- Job Title and Company -->
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="jc-title" style="font-size: 18px; font-weight: 700; margin-bottom: 4px; color: #1a1a1a; line-height: 1.3;">
                                                <a href="{{ route('jobs.show', $job->slug) }}" style="color: #1a1a1a; text-decoration: none;">{{ $job->title }}</a>
                                            </div>
                                            <div class="jc-company" style="font-size: 14px; color: #1a1a1a; margin-bottom: 0;">
                                                {{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}
                                            </div>
                                        </div>
                                        <!-- Category Tag (Top Right) -->
                                        <div class="jc-tag" style="position: absolute; top: 0; right: 0; font-size: 12px; background: #f3f4f6; padding: 6px 12px; border-radius: 20px; color: #1a1a1a; white-space: nowrap; font-weight: 500;">
                                            {{ optional($job->category)->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <!-- Location -->
                                    <div class="jc-location" style="display: flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 12px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;">
                                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $job->location_city }}{{ $job->location_country ? ', ' . $job->location_country : '' }}</span>
                                    </div>
                                    <!-- Employment Type and Experience -->
                                    <div class="jc-employment" style="display: flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7280; margin-bottom: 16px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #6b7280;">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }} • {{ $job->experience_years ?? 'N/A' }} Years Experience</span>
                                    </div>
                                    <!-- Separator Line -->
                                    <div style="height: 1px; background: #e5e7eb; margin-bottom: 16px;"></div>
                                    <!-- Salary -->
                                    <div class="jc-salary" style="display: flex; align-items: baseline; justify-content: space-between;">
                                        <div style="font-size: 18px; font-weight: 700; color: #1a1a1a;">
                                            @if(!empty($job->salary_min) && !empty($job->salary_max))
                                                {{ $job->salary_currency ?? 'AED' }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }}
                                            @else
                                                <span style="color: #6b7280; font-weight: 500;">Negotiable</span>
                                            @endif
                                        </div>
                                        @if(!empty($job->salary_min) && !empty($job->salary_max))
                                        <div style="font-size: 14px; color: #6b7280; font-weight: 400;">
                                            / {{ ucfirst($job->salary_period ?? 'Monthly') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- Pagination -->
                    <div class="mt-3" style="width: 100%; margin-top: 40px;">
                        @include('partials.simple-pagination', ['paginator' => $recommendedJobs->withQueryString()])
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
