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

.featured-jobs-grid .owl-carousel {
    padding: 0 !important;
}

.featured-jobs-grid .owl-stage-outer {
    padding: 0 !important;
}

.featured-jobs-grid .owl-item {
    padding: 0 10px !important;
}

.featured-job-card {
    background: #ffffff !important;
    border: 1px solid #eee !important;
    border-radius: 14px !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    transition: all 0.3s ease !important;
    position: relative !important;
    overflow: hidden !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    cursor: pointer !important;
}

.featured-job-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    transform: translateY(-2px) !important;
    border-color: #ddd !important;
}

.job-card-header {
    padding: 20px 25px 15px !important;
    background: #ffffff !important;
    position: relative !important;
    border-bottom: 1px solid #eee !important;
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
}

.company-logo img {
    width: 28px !important;
    height: 28px !important;
    object-fit: cover !important;
    filter: brightness(0) saturate(100%) invert(27%) sepia(87%) saturate(2837%) hue-rotate(230deg) brightness(95%) contrast(96%) !important;
}

.company-name {
    flex: 1 !important;
    min-width: 0 !important;
}

.company-name h3 {
    font-size: 12px !important;
    color: #666 !important;
    margin: 0 !important;
    line-height: 1.4 !important;
    word-wrap: break-word !important;
    letter-spacing: 0.2px !important;
    font-weight: 500 !important;
}

.job-card-body {
    padding: 20px 25px 15px !important;
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
    font-size: 14px !important;
    color: #000 !important;
    text-decoration: none !important;
    line-height: 1.5 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    transition: color 0.2s ease !important;
    letter-spacing: -0.2px !important;
    margin-bottom: 0 !important;
    font-weight: 700 !important;
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
    background: #eee !important;
    color: #000 !important;
    font-size: 11px !important;
    padding: 4px 10px !important;
    border-radius: 20px !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    border: none !important;
    display: inline-block !important;
    font-weight: 500 !important;
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

.meta-badge:hover {
    background: #f3f4f6 !important;
    border-color: #d1d5db !important;
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
    padding: 15px 25px 20px !important;
    border-top: 1px solid #eee !important;
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

.price-ad p span.price-period {
    font-size: 12px !important;
    font-weight: 500 !important;
    color: #6b7280 !important;
    white-space: nowrap !important;
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
    row-gap: 25px;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
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

.status-chip {
    position: absolute !important;
    top: 16px !important;
    right: 16px !important;
    padding: 6px 14px !important;
    border-radius: 999px !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.6px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
}

.status-chip.recommended {
    background: rgba(255, 255, 255, 0.18) !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.35) !important;
}

.status-chip.featured {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%) !important;
    color: #1f2937 !important;
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35) !important;
}

.status-chip.premium {
    background: linear-gradient(135deg, #ec4899 0%, #6366f1 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35) !important;
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

@media (max-width: 768px) {
    .featured-jobs-section-wrapper .section-title h2 {
        font-size: 22px !important;
    }

    .featured-job-card {
        border-radius: 12px !important;
    }

    .job-card-header {
        padding: 12px 14px 10px !important;
    }

    .company-logo {
        width: 36px !important;
        height: 36px !important;
    }

    .company-logo img {
        width: 24px !important;
        height: 24px !important;
    }

    .company-name h3 {
        font-size: 12px !important;
    }

    .job-card-body {
        padding: 12px 14px 10px !important;
    }

    .job-title a {
        font-size: 14px !important;
    }

    .category-badge-top {
        font-size: 9px !important;
        padding: 4px 8px !important;
    }

    .meta-badge {
        font-size: 9px !important;
        padding: 3px 8px !important;
    }

    .location-info {
        font-size: 10px !important;
    }

    .location-info img {
        width: 12px !important;
        height: 12px !important;
    }

    .job-card-footer {
        padding: 10px 14px 12px !important;
    }

    .price-ad p {
        font-size: 13px !important;
    }

    .price-ad p span.price-amount {
        font-size: 13px !important;
    }

    .price-ad p span.price-period {
        font-size: 11px !important;
    }
}

@media (max-width: 480px) {
    .job-card-header {
        padding: 10px 12px 8px !important;
    }

    .company-logo {
        width: 32px !important;
        height: 32px !important;
    }

    .company-logo img {
        width: 20px !important;
        height: 20px !important;
    }

    .company-name h3 {
        font-size: 11px !important;
    }

    .job-card-body {
        padding: 10px 12px 8px !important;
    }

    .job-title a {
        font-size: 13px !important;
    }

    .job-card-footer {
        padding: 10px 12px 12px !important;
    }

    .price-ad p {
        font-size: 13px !important;
    }

    .price-ad p span.price-amount {
        font-size: 13px !important;
    }

    .price-ad p span.price-period {
        font-size: 11px !important;
    }
}
</style>
@endpush

@section('content')
<!-- Simple Breadcrumb -->
<div style="width: 90%; margin: 40px auto 20px; padding: 0 20px;">
    <nav style="font-size: 13px; color: #666;">
        <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Home</a> / 
        <span style="color: #000;">Browse Jobs</span>
    </nav>
</div>

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
      <div class="container" style="max-width: 100%; width: 90%; margin: 0 auto; padding: 0 20px;">
         <h2 class="section-title" style="font-size: 24px; font-weight: 700; margin-left: 60px; margin-bottom: 10px; margin-top: 20px; color: #000;">Current Jobs</h2>
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

 <div class="col-lg-9 fadeInLeft">
<div class="cate_list m-0">
        @if($featuredJobs->count())
        <div class="featured-jobs-section-wrapper">
            <h2 class="section-title" style="font-size: 24px; font-weight: 700; margin-left: 60px; margin-bottom: 10px; margin-top: 20px; color: #000;">Featured Jobs</h2>
            <div class="featured-jobs-grid row g-4">
                @foreach($featuredJobs as $job)
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="featured-job-card">
                        <div class="job-card-header">
                            <div class="company-header">
                                <div class="company-logo">
                                    <img src="{{ asset('images/job.svg') }}" alt="company-logo">
                                </div>
                                <div class="company-name">
                                    <h3>{{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-body">
                            <div class="job-title">
                                <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                            </div>
                            <div class="job-meta">
                                <div class="category-badge-top">{{ optional($job->category)->name ?? 'N/A' }}</div>
                                <div class="meta-badge">
                                    Type: <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                                </div>
                                <div class="meta-badge">
                                    Experience: <span>{{ $job->experience_years ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="location-info">
                                <img src="{{ asset('images/location.svg') }}" alt="location">
                                <span>{{ $job->location_city }}</span>
                            </div>
                        </div>
                        <div class="job-card-footer">
                            <div class="price-ad">
                                <p>
                                    @if(!empty($job->salary_min) && !empty($job->salary_max))
                                        <span class="price-amount">{{ $job->salary_currency ?? 'AED' }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }}</span>
                                        <span class="price-period">/ {{ ucfirst($job->salary_period ?? 'monthly') }}</span>
                                    @else
                                        <span class="price-negotiable">Negotiable</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @php
            $listHeading = ($postedAs ?? null) === 'featured' ? 'Featured Jobs' : 'Recommended Jobs';
        @endphp
        <h2 class="section-title" style="font-size: 24px; font-weight: 700; margin-left: 60px; margin-bottom: 10px; margin-top: 20px; color: #000;">{{ $listHeading }}</h2>
        <div class="recommended-jobs-grid row g-4">
            @foreach($recommendedJobs as $job)
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="featured-job-card">
                    <div class="job-card-header">
                        @php
                            $badgeLabel = 'Recommended';
                            $badgeClass = 'recommended';

                            $priorityValue = strtolower($job->priority ?? '');
                            $labelLower = strtolower($badgeLabel);

                            if ($job->isFeatured()) {
                                $badgeLabel = 'Featured';
                                $badgeClass = 'featured';
                            } elseif (!empty($job->priority) && $priorityValue !== 'normal') {
                                $badgeLabel = ucfirst(str_replace('_', ' ', $job->priority));
                                $badgeClass = str_contains($priorityValue, 'premium') ? 'premium' : 'recommended';
                            } elseif (($postedAs ?? null) === 'featured') {
                                $badgeLabel = 'Featured';
                                $badgeClass = 'featured';
                            }
                        @endphp
                        <div class="company-header">
                            <div class="company-logo">
                                <img src="{{ asset('images/job.svg') }}" alt="company-logo">
                            </div>
                            <div class="company-name">
                                <h3>{{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="job-card-body">
                        <div class="job-title">
                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                        </div>
                        <div class="job-meta">
                            <div class="category-badge-top">{{ optional($job->category)->name ?? 'N/A' }}</div>
                            <div class="meta-badge">
                                Type: <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                            </div>
                            <div class="meta-badge">
                                Experience: <span>{{ $job->experience_years ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-badge">
                                Education: <span>{{ $job->education_level ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="location-info">
                            <img src="{{ asset('images/location.svg') }}" alt="location">
                            <span>{{ $job->location_city }}</span>
                        </div>
                    </div>
                    <div class="job-card-footer">
                        <div class="price-ad">
                            <p>
                                @if(!empty($job->salary_min) && !empty($job->salary_max))
                                    <span class="price-amount">{{ $job->salary_currency ?? 'AED' }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }}</span>
                                    <span class="price-period">/ {{ ucfirst($job->salary_period ?? 'monthly') }}</span>
                                @else
                                    <span class="price-negotiable">Negotiable</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

         <div class="mt-3">
             @include('partials.simple-pagination', ['paginator' => $recommendedJobs->withQueryString()])
         </div>
      </div> 


    </div>


</div>


       


      </div> 
   </section>
@endsection
