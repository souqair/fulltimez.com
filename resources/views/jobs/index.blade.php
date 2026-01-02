@extends('layouts.app')

@section('title', 'Browse Jobs')

@push('styles')
<style>
body {
    overflow-x: hidden !important;
}

/* Jobs header (same vibe as candidates) */
.jobs-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 12px 14px;
    border: 1px solid #eee;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(20, 28, 54, 0.06);
    margin: 10px 0 18px;
}

.jobs-page-title h2 {
    font-size: 24px;
    font-weight: 800;
    color: #0d1f4a;
    margin: 0;
    letter-spacing: 0.2px;
}

.jobs-page-title .meta {
    font-size: 12px;
    color: #6f7795;
}

.jobs-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
}

.jobs-icon-btn {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    border: 1px solid #eee;
    background: #fff;
    color: #0d1f4a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.jobs-icon-btn:hover {
    box-shadow: 0 6px 18px rgba(20, 28, 54, 0.08);
    transform: translateY(-1px);
}

.jobs-icon-btn.active {
    background: #0d1f4a;
    border-color: #0d1f4a;
    color: #fff;
}

.jobs-search-popover {
    position: absolute;
    top: 70px;
    right: 0;
    width: min(520px, calc(100vw - 40px));
    background: #fff;
    border: 1px solid #eee;
    border-radius: 16px;
    box-shadow: 0 18px 50px rgba(20, 28, 54, 0.12);
    padding: 14px;
    display: none;
    z-index: 50;
}

.jobs-search-popover.open {
    display: block;
}

.jobs-search-popover label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #0d1f4a;
    margin-bottom: 8px;
}

.jobs-search-row {
    display: flex;
    gap: 10px;
    align-items: center;
}

.jobs-search-row input {
    flex: 1;
    height: 44px;
    border-radius: 12px;
    border: 1px solid #e6e9f2;
    padding: 0 14px;
    font-size: 14px;
}

.jobs-search-row button {
    height: 44px;
    border-radius: 12px;
    border: 0;
    background: #0d1f4a;
    color: #fff;
    padding: 0 16px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}

.jobs-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 14px;
    border: 1px solid #eee;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 10px 26px rgba(20, 28, 54, 0.05);
    margin: 22px 0 12px;
}

.jobs-section-header .title {
    font-size: 16px;
    font-weight: 800;
    color: #0d1f4a;
    margin: 0;
}

.jobs-section-header .meta {
    font-size: 12px;
    color: #6f7795;
    white-space: nowrap;
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
    color: #1a1a1a !important;
    white-space: nowrap !important;
    font-weight: 600 !important;
}

.jobs-grid {
    margin-bottom: 40px;
}

/* Make jobs cards more readable (override inline styles) */
.jobs-grid .job-card {
    padding: 30px !important;
    min-height: 260px !important;
    border-radius: 16px !important;
}

.jobs-grid .jc-title,
.jobs-grid .jc-title a {
    font-size: 16px !important;
    font-weight: 800 !important;
}

.jobs-grid .jc-company {
    font-size: 13px !important;
}

.jobs-grid .jc-info {
    font-size: 13px !important;
    line-height: 1.7 !important;
}

.jobs-grid .jc-tag {
    font-size: 12px !important;
    padding: 6px 12px !important;
    border-radius: 999px !important;
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
    .cate_list {
        padding: 0px 0px !important;
    }
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

/* Mobile Responsive Styles */
@media (max-width: 991px) {
    /* Hide desktop filters on mobile */
    .col-lg-3 {
        display: none !important;
    }
    
    /* Full width for jobs column on mobile */
    .col-lg-9 {
        width: 100% !important;
        max-width: 100% !important;
        margin-top: 0 !important;
        padding: 0 !important;
    }
    
    /* Row adjustments */
    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    
    /* Container adjustments */
    section.category-wrap > div {
        width: 100% !important;
        padding: 0 15px !important;
    }
    
    /* Breadcrumb mobile */
    div[style*="width: 90%"] {
        width: 95% !important;
        padding: 0 15px !important;
        margin: 20px auto 15px !important;
    }
    
    /* Section titles mobile */
    .section-title {
        margin-left: 0 !important;
        font-size: 20px !important;
        padding: 0 15px !important;
    }
    
    /* Jobs grid mobile */
    .jobs-grid {
        grid-template-columns: 1fr !important;
        width: 100% !important;
        gap: 20px !important;
        padding: 0 !important;
    }
    
    /* Job cards mobile */
    .job-card {
        padding: 20px !important;
        margin: 0 !important;
    }
    
    /* Job card content mobile */
    .jc-top {
        flex-direction: column !important;
        gap: 10px !important;
    }
    
    .jc-tag {
        margin-left: 0 !important;
        align-self: flex-start !important;
    }
    
    .jc-info {
        font-size: 11px !important;
    }
    
    .jc-salary {
        font-size: 13px !important;
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
    
    .section-title {
        font-size: 18px !important;
        padding: 0 10px !important;
    }
    
    .jobs-grid {
        gap: 15px !important;
    }
    
    .job-card {
        padding: 15px !important;
    }
    
    .jc-title {
        font-size: 13px !important;
    }
    
    .jc-company {
        font-size: 11px !important;
    }
    
    .jc-info {
        font-size: 10px !important;
        line-height: 1.5 !important;
    }
    
    .jc-salary {
        font-size: 12px !important;
    }
    
    .jc-monthly {
        font-size: 10px !important;
    }
}
</style>
@endpush

@section('content')
<!-- Simple Breadcrumb -->
<div style="width: 90%; margin: 40px auto 20px; padding: 0 20px;">
    <nav style="font-size: 13px; color: #666;">
       
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
      <div class="" style="max-width: 100%; width: 1635px; margin: 0 auto; padding: 0 20px;">
        
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
<div class="jobs-page-header" id="jobsPageHeader">
    <div class="jobs-page-title">
        <h2>Browse Jobs</h2>
        <div class="meta">{{ number_format($jobCount) }} jobs</div>
    </div>

    <div class="jobs-toolbar">
        <button type="button" class="jobs-icon-btn" id="jobsSearchBtn" aria-label="Search">
            <i class="fas fa-search"></i>
        </button>
        <button type="button" class="jobs-icon-btn" id="jobsFilterBtn" aria-label="Filters">
            <i class="fas fa-sliders-h"></i>
        </button>
    </div>

    <div class="jobs-search-popover" id="jobsSearchPopover">
        <form action="{{ route('jobs.index') }}" method="GET">
            <label for="jobsTitleSearch">Search jobs</label>
            <div class="jobs-search-row">
                <input type="text" id="jobsTitleSearch" name="title" placeholder="e.g. Sales Manager" value="{{ request('title') }}">
                <button type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
            <div class="col-lg-3 fadeInLeft d-none d-lg-block" id="jobsSidebarCol">
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

 <div class="col-lg-9 fadeInLeft" style="margin-top: -20px;" id="jobsMainCol">
<div class="cate_list m-0">
        @if($featuredJobs->count())
        <div class="featured-jobs-section-wrapper">
            <div class="jobs-section-header">
                <div class="title">Featured Jobs</div>
                <div class="meta">{{ $featuredJobs->count() }} jobs</div>
            </div>
            <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; width: 100%; margin: 0; padding: 26px 0;">
                @foreach($featuredJobs as $job)
                <div class="job-card" style="border: 1px solid #eee; border-radius: 14px; padding: 25px; background: white; cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('jobs.show', $job->slug) }}'">
                    <div class="jc-top" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <div class="jc-title" style="font-size: 14px; font-weight: 700; margin-bottom: 5px; color: #000;">
                                <a href="{{ route('jobs.show', $job->slug) }}" style="color: #000; text-decoration: none;">{{ $job->title }}</a>
                            </div>
                            <div class="jc-company" style="font-size: 12px; color: #666; margin-bottom: 15px;">
                                {{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}
                            </div>
                        </div>
                        <div class="jc-tag" style="font-size: 11px; background: #eee; padding: 4px 10px; border-radius: 20px; color: #000; white-space: nowrap; margin-left: 15px;">
                            {{ optional($job->category)->name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="jc-info" style="font-size: 12px; color: #444; line-height: 1.7; margin-bottom: 15px;">
                        📍 {{ $job->location_city }}{{ $job->location_country ? ', ' . $job->location_country : '' }}<br/>
                        ⏰ {{ optional($job->employmentType)->name ?? 'N/A' }} • {{ optional($job->experienceYear)->name ?? 'N/A' }} Experience
                    </div>
                    <div class="jc-salary" style="font-size: 14px; font-weight: 700; margin-top: 15px; color: #000;">
                        @if(in_array($job->salary_type, ['negotiable', 'salary_plus_commission']))
                            <span style="color: #777; font-weight: normal;">
                                @if($job->salary_type == 'negotiable')
                                    Negotiable
                                @elseif($job->salary_type == 'salary_plus_commission')
                                    Commission based
                                @endif
                            </span>
                        @elseif(!empty($job->salary_min) && !empty($job->salary_max) && in_array($job->salary_type, ['fixed', 'based_on_experience']))
                            {{ optional($job->salaryCurrency)->code ?? ($job->salary_currency ?? 'AED') }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }} <span class="jc-monthly" style="font-size: 11px; color: #777; font-weight: normal;">/ {{ optional($job->salaryPeriod)->name ?? ucfirst($job->salary_period ?? 'Monthly') }}</span>
                        @else
                            <span style="color: #777; font-weight: normal;">Negotiable</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @php
            $listHeading = ($postedAs ?? null) === 'featured' ? 'Featured Jobs' : 'Recommended Jobs';
        @endphp
        <div class="jobs-section-header">
            <div class="title">{{ $listHeading }}</div>
            <div class="meta">{{ number_format($jobCount) }} jobs</div>
        </div>
        <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; width: 100%; margin: 0; padding: 26px 0;">
            @foreach($recommendedJobs as $job)
            <div class="job-card" style="border: 1px solid #eee; border-radius: 14px; padding: 25px; background: white; cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('jobs.show', $job->slug) }}'">
                <div class="jc-top" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <div class="jc-title" style="font-size: 14px; font-weight: 700; margin-bottom: 5px; color: #000;">
                            <a href="{{ route('jobs.show', $job->slug) }}" style="color: #000; text-decoration: none;">{{ $job->title }}</a>
                        </div>
                        <div class="jc-company" style="font-size: 12px; color: #666; margin-bottom: 15px;">
                            {{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}
                        </div>
                    </div>
                    <div class="jc-tag" style="font-size: 11px; background: #eee; padding: 4px 10px; border-radius: 20px; color: #000; white-space: nowrap; margin-left: 15px;">
                        {{ optional($job->category)->name ?? 'N/A' }}
                    </div>
                </div>
                <div class="jc-info" style="font-size: 12px; color: #444; line-height: 1.7; margin-bottom: 15px;">
                    📍 {{ $job->location_city }}{{ $job->location_country ? ', ' . $job->location_country : '' }}<br/>
                    ⏰ {{ optional($job->employmentType)->name ?? 'N/A' }} • {{ optional($job->experienceYear)->name ?? 'N/A' }} Experience
                </div>
                <div class="jc-salary" style="font-size: 14px; font-weight: 700; margin-top: 15px; color: #000;">
                    @if(in_array($job->salary_type, ['negotiable', 'salary_plus_commission']))
                        <span style="color: #777; font-weight: normal;">
                            @if($job->salary_type == 'negotiable')
                                Negotiable
                            @elseif($job->salary_type == 'salary_plus_commission')
                                Commission based
                            @endif
                        </span>
                    @elseif(!empty($job->salary_min) && !empty($job->salary_max) && in_array($job->salary_type, ['fixed', 'based_on_experience']))
                        {{ optional($job->salaryCurrency)->code ?? ($job->salary_currency ?? 'AED') }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }} <span class="jc-monthly" style="font-size: 11px; color: #777; font-weight: normal;">/ {{ optional($job->salaryPeriod)->name ?? ucfirst($job->salary_period ?? 'Monthly') }}</span>
                    @else
                        <span style="color: #777; font-weight: normal;">Negotiable</span>
                    @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('jobsSearchBtn');
    const filterBtn = document.getElementById('jobsFilterBtn');
    const popover = document.getElementById('jobsSearchPopover');
    const sidebar = document.getElementById('jobsSidebarCol');
    const mainCol = document.getElementById('jobsMainCol');

    function closePopover() {
        if (!popover) return;
        popover.classList.remove('open');
        if (searchBtn) searchBtn.classList.remove('active');
    }

    if (searchBtn && popover) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const willOpen = !popover.classList.contains('open');
            closePopover();
            if (willOpen) {
                popover.classList.add('open');
                searchBtn.classList.add('active');
                const input = document.getElementById('jobsTitleSearch');
                if (input) setTimeout(() => input.focus(), 50);
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (!popover || !popover.classList.contains('open')) return;
        const header = document.getElementById('jobsPageHeader');
        if (header && !header.contains(e.target)) {
            closePopover();
        }
    });

    if (filterBtn && sidebar && mainCol) {
        filterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closePopover();
            const isHidden = sidebar.classList.contains('d-none');

            if (isHidden) {
                sidebar.classList.remove('d-none');
                filterBtn.classList.remove('active');
                mainCol.classList.add('col-lg-9');
                mainCol.classList.remove('col-12');
            } else {
                sidebar.classList.add('d-none');
                filterBtn.classList.add('active');
                mainCol.classList.remove('col-lg-9');
                mainCol.classList.add('col-12');
            }
        });
    }
});
</script>

@endsection
