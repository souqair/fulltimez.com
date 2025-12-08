@extends('layouts.app')

@section('title', 'FullTimez - Home')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@push('styles')
<style>
/* Global Container Fix */
body {
    overflow-x: hidden !important;
}

/* Modern Compact Featured Jobs Design */
.category-wrap.jobwrp .main_title {
    font-size: 32px !important;
    font-weight: 700 !important;
    color: #1a1a1a !important;
    text-align: center !important;
    margin-bottom: 25px !important;
    letter-spacing: -0.5px !important;
    position: relative !important;
    padding-bottom: 15px !important;
}

.category-wrap.jobwrp .main_title::after {
    content: '' !important;
    position: absolute !important;
    bottom: 0 !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: 60px !important;
    height: 4px !important;
    background: #2772e8 !important;
    border-radius: 2px !important;
}

.featured-jobs-grid {
    padding: 15px 0 !important;
}

.featured-jobs-grid .owl-carousel {
    padding: 0 !important;
}

.featured-jobs-grid .owl-stage-outer {
    padding: 0 !important;
    overflow: hidden !important;
    width: 100% !important;
}

.featured-jobs-grid .owl-item {
    padding: 0 8px !important;
}

.featured-jobs-grid .owl-stage {
    display: flex !important;
    align-items: stretch !important;
}

.featured-job-card {
    background: #ffffff !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: visible !important;
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

.featured-job-card a:hover {
    color: #2772e8 !important;
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

button svg{
    color: #ffff !important;
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

@media (max-width: 768px) {
    .featured-jobs-grid {
        overflow: hidden;
        width: 100%;
    }
    
    .featured-jobs-grid .owl-item {
        padding: 0 6px !important;
    }
    
    .featured-candidates-carousel-wrapper {
        overflow: hidden;
        width: 100%;
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
    .featured-jobs-grid .owl-item {
        padding: 0 5px !important;
    }
    
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
        padding: 12px 16px 16px !important;
    }
    
    .price-ad p {
        font-size: 14px !important;
    }
    
    .price-ad p span.price-amount {
        font-size: 14px !important;
    }
    
    .price-ad p span.price-period {
        font-size: 11px !important;
    }
}

.container {
    max-width: 100% !important;
    overflow-x: hidden !important;
}

/* Don't affect featured candidates container */
.featured-candidates-section .container {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 0 15px !important;
    overflow: visible !important;
    width: 100% !important;
}

@media (min-width: 1200px) {
    .featured-candidates-section .container {
        max-width: 1200px !important;
    }
}

@media (min-width: 992px) and (max-width: 1199px) {
    .featured-candidates-section .container {
        max-width: 960px !important;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .featured-candidates-section .container {
        max-width: 720px !important;
    }
}

/* Recommended Jobs Section Styling */
.jobs-wrap {
    padding: 0;
}

@media (max-width: 991.98px) {
    .jobs-wrap {
        padding: 0 !important;
    }
}

.jobs-wrap .jobs {
    background: #ffffff !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    transition: all 0.3s ease !important;
    padding: 20px !important;
    margin-bottom: 24px !important;
    height: 100% !important;
}

.jobs-wrap .jobs:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
    transform: translateY(-4px) !important;
    border-color: #cbd5e1 !important;
}

.jobs-wrap .job-content {
    margin-bottom: 16px !important;
}

.jobs-wrap .jobdate {
    font-size: 11px !important;
    color: #6b7280 !important;
    font-weight: 500 !important;
    margin-bottom: 8px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.jobs-wrap .job-content > p {
    font-size: 14px !important;
    color: #1a1a1a !important;
    font-weight: 600 !important;
    margin-bottom: 12px !important;
}

.jobs-wrap .job-content h3 {
    margin-bottom: 16px !important;
}

.jobs-wrap .job-content h3 a {
    font-size: 18px !important;
    color: #111827 !important;
    text-decoration: none !important;
    line-height: 1.5 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    transition: color 0.2s ease !important;
    letter-spacing: -0.2px !important;
}

.jobs-wrap .job-content h3 a:hover {
    color: #1a1a1a !important;
}

.jobs-wrap .tags {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 0 16px 0 !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
}

.jobs-wrap .tags li {
    margin: 0 !important;
}

.jobs-wrap .tags li a {
    display: inline-block !important;
    padding: 4px 12px !important;
    background: #f3f4f6 !important;
    color: #374151 !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    border-radius: 4px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    border: 1px solid #e5e7eb !important;
}

.jobs-wrap .tags li a:hover {
    background: #1a1a1a !important;
    color: #ffffff !important;
    border-color: #1a1a1a !important;
}

.jobs-wrap .d-flex.align-items-center.justify-content-between {
    padding-top: 16px !important;
    border-top: 1px solid #f3f4f6 !important;
    margin-top: auto !important;
}

.jobs-wrap .job_price {
    font-size: 15px !important;
    color: #000 !important;
}

.jobs-wrap .job_price span {
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #6b7280 !important;
    margin-left: 8px !important;
}

.jobs-wrap .readmore {
    margin: 0 !important;
}

.jobs-wrap .readmore a {
    padding: 8px 20px !important;
    background: #1a1a1a !important;
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    display: inline-block !important;
}

.jobs-wrap .readmore a:hover {
    background: #5568d3 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
}

@media (max-width: 768px) {
    .jobs-wrap .jobs {
        padding: 16px !important;
        margin-bottom: 20px !important;
    }
    
    .jobs-wrap .job-content h3 a {
        font-size: 17px !important;
    }
    
    .jobs-wrap .d-flex.align-items-center.justify-content-between {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 12px !important;
    }
    
    .jobs-wrap .readmore {
        width: 100% !important;
    }
    
    .jobs-wrap .readmore a {
        width: 100% !important;
        text-align: center !important;
    }
}

/* Browse Buttons Styling */
.btn-browse-jobs,
.btn-browse-seekers {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 32px;
    background: #1a1a1a;
    color: #ffffff;
    font-size: 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
}

.btn-browse-jobs:hover,
.btn-browse-seekers:hover {
    background: #5568d3;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    text-decoration: none;
}

.btn-browse-jobs i,
.btn-browse-seekers i {
    font-size: 16px;
}

@media (max-width: 768px) {
    .btn-browse-jobs,
    .btn-browse-seekers {
        padding: 12px 24px;
        font-size: 15px;
        width: 100%;
        max-width: 300px;
    }
}

/* Featured Candidates Section */
.featured-candidates-section {
    background: #f8f9fa;
    padding: 60px 0;
    overflow: visible !important;
    width: 100%;
    position: relative;
}

.featured-candidates-header {
    text-align: center;
    margin-bottom: 50px;
}

.featured-candidates-title {
    font-size: 42px;
    color: #2d3748;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0 0 12px 0;
}

.featured-candidates-subtitle {
    font-size: 16px;
    color: #718096;
    margin: 0 0 20px 0;
}

.featured-candidates-separator {
    width: 80px;
    height: 3px;
    background: #0077f6;
    margin: 0 auto;
    border-radius: 2px;
}

.featured-candidates-carousel-wrapper {
    padding: 20px 0;
    overflow: hidden;
    width: 100%;
    position: relative;
    max-width: 100%;
}

.featured-candidates-carousel-wrapper .owl-carousel {
    padding: 0;
    width: 100%;
    max-width: 100%;
}

.featured-candidates-carousel-wrapper .owl-stage-outer {
    overflow: hidden;
    width: 100%;
    max-width: 100%;
    position: relative;
}

.featured-candidates-carousel-wrapper .owl-stage {
    display: flex;
    align-items: stretch;
}

.featured-candidates-carousel-wrapper .owl-item {
    padding: 0 10px;
    display: flex;
    height: auto;
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
    width: 100%;
    min-height: 400px;
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
    background: #1977f5;
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
}

.candidate-rate {
    font-size: 16px;
    color: #000 !important;
    margin: 0 0 8px 0;
}

.candidate-profession {
    font-size: 14px;
    color: #4a5568;
    margin: 0 0 12px 0;
}

.candidate-location {
    font-size: 14px;
    color: #2d3748;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.candidate-location i {
    font-size: 14px;
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
    background: #0077f6;
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

@media (max-width: 768px) {
    .featured-candidates-title {
        font-size: 32px;
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

/* Split Banner Section */
.split-banner-section {
    margin: 60px 0;
}

.split-banner-jobseeker,
.split-banner-employer {
    position: relative;
    min-height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.split-banner-jobseeker {
    /* Background set via inline style for dynamic image loading */
}

.split-banner-employer {
    /* Background set via inline style for dynamic image loading */
}

.split-banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    backdrop-filter: blur(2px);
}

.split-banner-jobseeker .split-banner-overlay {
    background: rgba(0, 123, 255, 0.85);
}

.split-banner-employer .split-banner-overlay {
    background:rgb(13 102 197);
}

.split-banner-content {
    position: relative;
    z-index: 10;
    text-align: center;
    padding: 40px 30px;
    max-width: 500px;
    color: #ffffff;
}

.split-banner-title {
    font-size: 48px;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0 0 24px 0;
    color: #ffffff;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.split-banner-description {
    font-size: 18px;
    line-height: 1.6;
    margin: 0 0 32px 0;
    color: #ffffff;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}

.split-banner-btn {
    display: inline-block;
    background: #ffffff;
    color: #2d3748;
    padding: 14px 40px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(45, 55, 72, 0.1);
}

.split-banner-btn:hover {
    background: #f8f9fa;
    color: #1a202c;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    text-decoration: none;
}

@media (max-width: 992px) {
    .split-banner-jobseeker,
    .split-banner-employer {
        min-height: 400px;
    }
    
    .split-banner-title {
        font-size: 36px;
    }
    
    .split-banner-description {
        font-size: 16px;
    }
}

@media (max-width: 768px) {
    .split-banner-jobseeker,
    .split-banner-employer {
        min-height: 350px;
    }
    
    .split-banner-title {
        font-size: 28px;
        letter-spacing: 1px;
    }
    
    .split-banner-description {
        font-size: 14px;
        margin-bottom: 24px;
    }
    
    .split-banner-btn {
        padding: 12px 32px;
        font-size: 14px;
    }
    
    .split-banner-content {
        padding: 30px 20px;
    }
}

/* Job Seekers Section Styling */
.seekerwrp .add-exp {
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
}

.seekerwrp .jobs-ad-card {
    background: #ffffff !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 16px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    transition: all 0.3s ease !important;
    padding: 20px !important;
    height: 100% !important;
    min-height: 130px !important;
    display: flex !important;
    flex-direction: column !important;
}

.seekerwrp .jobs-ad-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
    transform: translateY(-4px) !important;
    border-color: #cbd5e1 !important;
}

.seekerwrp .category-job {
    padding: 0 0 16px 0 !important;
    border-bottom: 1px solid #f3f4f6 !important;
    margin-bottom: 16px !important;
}

.seekerwrp .job-icons {
    margin-right: 12px !important;
}

.seekerwrp .job-icons img {
    display: none !important;
}

.seekerwrp .seeker-avatar {
    width: 64px !important;
    height: 64px !important;
    border-radius: 50% !important;
    background: #1a1a1a !important;
    border: 3px solid #e5e7eb !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 24px !important;
    color: #ffffff !important;
    transition: all 0.3s ease !important;
    flex-shrink: 0 !important;
    text-transform: uppercase !important;
}

.seekerwrp .jobs-ad-card:hover .seeker-avatar {
    border-color: #1a1a1a !important;
    transform: scale(1.05) !important;
}

.seekerwrp .categery-name h3 {
    font-size: 18px !important;
    color: #111827 !important;
    margin: 0 !important;
    line-height: 1.4 !important;
    word-wrap: break-word !important;
}

.seekerwrp .catebox {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}

.seekerwrp .add-title {
    margin-bottom: 14px !important;
}

.seekerwrp .add-title a {
    font-size: 16px !important;
    font-weight: 600 !important;
    color: #111827 !important;
    text-decoration: none !important;
    line-height: 1.5 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    transition: color 0.2s ease !important;
}

.seekerwrp .add-title a:hover {
    color: #1a1a1a !important;
}

.seekerwrp .carinfo {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 0 -28px 0 !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 12px !important;
}

.seekerwrp .carinfo li {
    font-size: 13px !important;
    color: #6b7280 !important;
    margin: 0 !important;
}

.seekerwrp .carinfo li span {
    color: #374151 !important;
    margin-left: 4px !important;
}

.seekerwrp .cartbx {
    margin-bottom: 14px !important;
}

.seekerwrp .cartbx a {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    color: #6b7280 !important;
    font-size: 13px !important;
    text-decoration: none !important;
}

.seekerwrp .cartbx img {
    width: 16px !important;
    height: 16px !important;
    opacity: 0.7 !important;
}

.seekerwrp .price-ad {
    margin-top: auto !important;
    padding-top: 14px !important;
    border-top: 1px solid #f3f4f6 !important;
}

.seekerwrp .price-ad p {
    font-size: 15px !important;
    color: #059669 !important;
    margin: 0 !important;
    text-align: left !important;
}

@media (max-width: 768px) {
    .seekerwrp .jobs-ad-card {
        padding: 16px !important;
    }
    
    .seekerwrp .seeker-avatar {
        width: 56px !important;
        height: 56px !important;
        font-size: 20px !important;
    }
    
    .seekerwrp .categery-name h3 {
        font-size: 16px !important;
    }
    
    .seekerwrp .add-title a {
        font-size: 15px !important;
    }
    
    .seekerwrp .carinfo {
        gap: 10px !important;
    }
    
    .seekerwrp .carinfo li {
        font-size: 12px !important;
    }
    
    .seekerwrp .price-ad p {
        font-size: 14px !important;
    }
}

/* Desktop Container Fix */
@media (min-width: 769px) {
    .category-wrap {
        overflow-x: hidden !important;
    }
    
    .jobs_list {
        overflow-x: hidden !important;
    }
    
    .container {
        max-width: 1200px !important;
        margin: 0 auto !important;
        overflow-x: hidden !important;
    }
}

.split-banner-jobseeker{
    border-radius: 35px 0 0 35px;}
   .split-banner-employer{
    border-radius:0 35px 35px 0;}
    
/* Home Page Responsive Improvements */
@media (max-width: 768px) {
    .main_title {
        font-size: 28px !important;
        text-align: center;
        margin-bottom: 30px;
    }
    .split-banner-jobseeker{
    border-radius: 35px 35px 0 0;}
   .split-banner-employer{
    border-radius:0 0 35px 35px;}
    .jobs_list {
        padding: 0 15px !important;
        display: block !important;
        width: 100% !important;
        overflow-x: hidden !important;
    }
    
    .category-wrap {
        overflow-x: hidden !important;
        padding: 0 15px !important;
    }
    
    .container {
        padding: 0 15px !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
    
    .jobs_list .item {
        width: 100% !important;
        display: flex !important;
        float: none !important;
        clear: both !important;
        margin-bottom: 20px !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        height: auto !important;
    }
    
    .add-exp {
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        flex: 1 !important;
    }
    
    .jobs-ad-card {
        height: 100% !important;
        min-height: 100% !important;
    }
    
    .jobs-ad-card {
        margin-bottom: 20px !important;
        border-radius: 14px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }
    
    .job-card-header {
        padding: 20px 18px 18px !important;
    }
    
    .header-top {
        margin-bottom: 14px !important;
    }
    
    .company-header {
        flex-direction: column !important;
        text-align: center !important;
        gap: 12px !important;
    }
    
    .company-logo {
        width: 52px !important;
        height: 52px !important;
        margin: 0 auto !important;
    }
    
    .company-name h3 {
        font-size: 15px !important;
        text-align: center !important;
    }
    
    .category-badge-top {
        font-size: 10px !important;
        padding: 4px 10px !important;
    }
    
    .job-card-body {
        padding: 0 18px 18px !important;
    }
    
    .job-title a {
        font-size: 17px !important;
        text-align: center !important;
    }
    
    .job-meta {
        justify-content: center !important;
        gap: 8px !important;
    }
    
    .meta-badge {
        font-size: 11px !important;
        padding: 5px 10px !important;
    }
    
    .location-info {
        justify-content: center !important;
        font-size: 12px !important;
    }
    
    .job-card-footer {
        padding: 14px 18px 18px !important;
    }
    
    .price-ad {
        text-align: center !important;
    }
    
    .price-ad p {
        font-size: 15px !important;
    }
}

@media (max-width: 480px) {
    .main_title {
        font-size: 24px !important;
    }
    
    .jobs-ad-card {
        border-radius: 12px !important;
    }
    
    .job-card-header {
        padding: 18px 16px 16px !important;
    }
    
    .header-top {
        margin-bottom: 12px !important;
    }
    
    .job-card-body {
        padding: 0 16px 16px !important;
    }
    
    .job-card-footer {
        padding: 12px 16px 16px !important;
    }
    
    .company-logo {
        width: 48px !important;
        height: 48px !important;
    }
    
    .company-name h3 {
        font-size: 14px !important;
    }
    
    .category-badge-top {
        font-size: 9px !important;
        padding: 4px 9px !important;
    }
    
    .job-title a {
        font-size: 16px !important;
    }
    
    .meta-badge {
        font-size: 10px !important;
        padding: 5px 9px !important;
    }
    
    .price-ad {
        text-align: center !important;
    }
    
    .price-ad p {
        font-size: 14px !important;
    }
}

/* Hero Section Responsive */
@media (max-width: 768px) {
    .hero {
        padding: 60px 20px 40px !important;
    }
    
    .hero h1 {
        font-size: 2.5rem !important;
        margin-bottom: 16px !important;
    }
    
    .hero p {
        font-size: 16px !important;
        margin-bottom: 40px !important;
    }
    
    .search-box {
        width: 95% !important;
        padding: 20px !important;
    }
    
    .search-box form {
        grid-template-columns: 1fr !important;
        gap: 16px !important;
    }
    
    .search-box form > div {
        width: 100% !important;
    }
    
    .search-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    
    .stats {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 30px !important;
        padding: 60px 0 !important;
        width: 95% !important;
    }
    
    .stats h2 {
        font-size: 2rem !important;
    }
    
    .stats p {
        font-size: 13px !important;
    }
    
    .cta-title {
        font-size: 24px !important;
    }
    
    .cta-description {
        font-size: 14px !important;
    }
}

@media (max-width: 480px) {
    .stats {
        grid-template-columns: 1fr !important;
        gap: 30px !important;
    }
    
    .stats h2 {
        font-size: 2rem !important;
    }
}

/* Featured Jobs Section Responsive */
@media (max-width: 768px) {
    .jobs-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        width: 95% !important;
    }
    
    .section-title {
        font-size: 24px !important;
    }
    
    .section-sub {
        font-size: 14px !important;
    }
    
    section > div:first-child {
        flex-direction: column !important;
        gap: 16px !important;
        align-items: flex-start !important;
    }
}

/* Footer Responsive */
@media (max-width: 768px) {
    .desktop-footer {
        padding: 40px 0 20px 0 !important;
    }
    
    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
    
    .terms {
        justify-content: center;
    }
}

/* Responsive Styles for New Design */
@media (max-width: 768px) {
    .hero {
        padding: 60px 20px !important;
    }
    
    .hero h1 {
        font-size: 32px !important;
    }
    
    .search-box {
        width: 95% !important;
        flex-direction: column !important;
        gap: 15px !important;
    }
    
    .search-box form {
        flex-direction: column !important;
    }
    
    .search-box .search-btn {
        width: 100% !important;
        padding: 14px 20px !important;
    }
    
    .stats {
        gap: 40px !important;
        padding: 40px 0 !important;
        width: 95% !important;
    }
    
    .section-title {
        margin-left: 20px !important;
        font-size: 20px !important;
    }
    
    .section-sub {
        margin-left: 20px !important;
    }
    
    .jobs-grid {
        display: block !important;
        grid-template-columns: none !important;
        width: 95% !important;
        gap: 0 !important;
    }
    
    .jobs-grid .job-card {
        margin-bottom: 20px !important;
    }
    
    .job-card {
        padding: 20px !important;
    }
    
    .two-box-container {
        flex-direction: column !important;
        width: 95% !important;
        gap: 25px !important;
    }
    
    .candidates-grid {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
        width: 95% !important;
        padding: 0 !important;
    }
    
    .candidates-grid .cand {
        margin-bottom: 0 !important;
    }
    
    section > div:first-child {
        flex-direction: column !important;
        gap: 16px !important;
        align-items: flex-start !important;
    }
}

/* Desktop/Web Version - Display Grid */
@media (min-width: 992px) {
    .candidates-grid {
        display: grid !important;
    }
}

.job-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px);
}

.job-card a:hover {
    color: #2772e8 !important;
}

.cand:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px);
}

    
</style>
@endpush

@section('hero')
<!-- Hero Section -->
<section class="hero" style="text-align: center; padding: 80px 20px 60px; background: #fafafa;">
    <h1 style="font-size: 4.5rem; font-weight: 700; line-height: 1.2; color: #000; margin: 60px 0 24px 0; letter-spacing: -0.5px; max-width: 800px; margin-left: auto; margin-right: auto;">
        Empowering Your<br>Career Journey
    </h1>
    <p style="margin: 0 0 130px 0; font-size: 18px; color: #6b7280; line-height: 1.6; max-width: 700px; margin-left: auto; margin-right: auto;">
        Whether you're searching for your first job or your next big opportunity,<br>we connect you with employers who value your talent.
    </p>
    
    <!-- Search Box -->
    <div class="search-box" style="background: #fff; padding: 30px; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); width: 90%; margin: 0 auto; max-width: 1000px;">
        <form action="{{ route('jobs.index') }}" method="GET" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 20px; align-items: end;">
            <!-- Country Dropdown -->
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="font-size: 14px; font-weight: 500; color: #1a1a1a; text-align: left; margin: 0;">Country</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <select name="location_country" style="width: 100%; padding: 12px 40px 12px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #fff; outline: none; appearance: none; cursor: pointer; transition: border-color 0.2s;" onfocus="this.style.borderColor='#1a1a1a';" onblur="this.style.borderColor='#e5e7eb';">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ request('location_country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <svg style="position: absolute; right: 14px; width: 18px; height: 18px; color: #6b7280; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>
            
            <!-- State/City Dropdown -->
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="font-size: 14px; font-weight: 500; color: #1a1a1a; text-align: left; margin: 0;">State</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <select name="location_city" style="width: 100%; padding: 12px 40px 12px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #fff; outline: none; appearance: none; cursor: pointer; transition: border-color 0.2s;" onfocus="this.style.borderColor='#1a1a1a';" onblur="this.style.borderColor='#e5e7eb';">
                        <option value="">All States</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->name }}" {{ request('location_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <svg style="position: absolute; right: 14px; width: 18px; height: 18px; color: #6b7280; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>
            
            <!-- Category Dropdown -->
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="font-size: 14px; font-weight: 500; color: #1a1a1a; text-align: left; margin: 0;">Category</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <select name="category" style="width: 100%; padding: 12px 40px 12px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; color: #1a1a1a; background: #fff; outline: none; appearance: none; cursor: pointer; transition: border-color 0.2s;" onfocus="this.style.borderColor='#1a1a1a';" onblur="this.style.borderColor='#e5e7eb';">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <svg style="position: absolute; right: 14px; width: 18px; height: 18px; color: #6b7280; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>
            
            <!-- Search Button -->
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="font-size: 14px; font-weight: 500; color: transparent; text-align: left; margin: 0; visibility: hidden;">Search</label>
                <button type="submit" class="search-btn" style="background: #000; color: #fff; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; white-space: nowrap; display: flex; align-items: center; gap: 8px; justify-content: center; transition: background 0.2s; height: 44px;" onmouseover="this.style.background='#1a1a1a';" onmouseout="this.style.background='#000';">
                    <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>
</section>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 0; width: 90%; max-width: 1200px; margin-left: auto; margin-right: auto;">

<!-- Statistics Section -->
<section class="stats" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; padding: 80px 0; width: 90%; max-width: 1200px; margin: 0 auto;">
    <div style="text-align: center;">
        <h2 style="font-size: 3rem; font-weight: 700; color: #000; margin: 0; line-height: 1.2;">
            <span style=" padding: 4px 8px; border-radius: 4px; display: inline-block;">10,000</span><span>+</span>
        </h2>
        <p style="font-size: 14px; color: #777; margin-top: 12px; margin-bottom: 0; font-weight: 400;">Active Jobs</p>
    </div>
    <div style="text-align: center;">
        <h2 style="font-size: 3rem; font-weight: 700; color: #000; margin: 0; line-height: 1.2;">5,000+</h2>
        <p style="font-size: 14px; color: #777; margin-top: 12px; margin-bottom: 0; font-weight: 400;">Companies</p>
    </div>
    <div style="text-align: center;">
        <h2 style="font-size: 3rem; font-weight: 700; color: #000; margin: 0; line-height: 1.2;">50,000+</h2>
        <p style="font-size: 14px; color: #777; margin-top: 12px; margin-bottom: 0; font-weight: 400;">Candidates</p>
    </div>
    <div style="text-align: center;">
        <h2 style="font-size: 3rem; font-weight: 700; color: #000; margin: 0; line-height: 1.2;">95%</h2>
        <p style="font-size: 14px; color: #777; margin-top: 12px; margin-bottom: 0; font-weight: 400;">Success Rate</p>
    </div>
</section>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 60px auto; width: 90%; max-width: 1200px;">
@endsection

@section('content')






   <!-- Featured Jobs Section -->
   <section style="margin-top: 60px; margin-bottom: 60px; padding: 0 5%;">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; width: 90%; max-width: 1200px; margin-left: auto; margin-right: auto;">
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
      
      <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 90%; max-width: 1200px; margin: 0 auto;">
         @foreach($featuredJobs->take(4) as $job)
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
   </section>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 60px auto; width: 90%; max-width: 1200px;">
 
<div class="ad-box" style="width: 70%; max-width: 800px; margin: 70px auto; text-align: center; padding: 25px; border: 1px solid #eee; border-radius: 12px; color: #777; font-size: 12px;">ADVERTISEMENT</div>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 60px auto; width: 90%; max-width: 1200px;">

<!-- Call to Action Section: Jobseeker & Employer -->
<style>
.two-box-container {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin: 80px auto;
    width: 90%;
    max-width: 1200px;
    flex-wrap: wrap;
    padding: 0;
}

.cta-box {
    flex: 1 1 calc(50% - 20px);
    min-width: 400px;
    padding: 50px 40px;
    border-radius: 14px;
    position: relative;
    text-align: center;
    transition: all 0.3s ease;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cta-box:hover {
    transform: translateY(-4px);
}

.cta-box-jobseeker {
    background: #1a1a1a;
    color: #ffffff;
    box-shadow: none;
}

.cta-box-employer {
    background: #ffffff;
    color: #000;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.cta-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    flex-shrink: 0;
}

.cta-box-jobseeker .cta-icon {
    background: #2d2d2d;
    color: #ffffff;
}

.cta-box-employer .cta-icon {
    background: #f3f4f6;
    color: #1a1a1a;
}

.cta-icon svg {
    width: 32px;
    height: 32px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

.cta-box h3 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 16px 0;
    color: inherit;
    letter-spacing: -0.3px;
}

.cta-box p {
    font-size: 15px;
    line-height: 1.6;
    margin: 0 0 32px 0;
    color: inherit;
    opacity: 0.9;
    max-width: 100%;
}

.cta-box-employer p {
    opacity: 0.8;
    color: #4b5563;
}

.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.cta-btn-jobseeker {
    background: #ffffff;
    color: #000000;
}

.cta-btn-jobseeker:hover {
    background: #f5f5f5;
    color: #000000;
}

.cta-btn-employer {
    background: #1a1a1a;
    color: #ffffff;
}

.cta-btn-employer:hover {
    background: #2d2d2d;
    color: #ffffff;
}

.cta-btn svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

@media (max-width: 768px) {
    .two-box-container {
        width: 95%;
        margin: 60px auto;
        gap: 25px;
        flex-direction: column;
    }
    
    .cta-box {
        min-width: 100%;
        padding: 40px 30px;
    }
    
    .cta-box h3 {
        font-size: 22px;
    }
    
    .cta-box p {
        font-size: 14px;
    }
}
</style>

<div class="two-box-container">
   <!-- Job Seeker Box -->
   <div class="cta-box cta-box-jobseeker">
      <div class="cta-icon">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
         </svg>
      </div>
      <h3>I Am a Job Seeker</h3>
      <p>Create your professional resume with our online builder and start applying for the best jobs.</p>
      <a href="{{ route('jobseeker.login') }}" class="cta-btn cta-btn-jobseeker">
         Get Started
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
         </svg>
      </a>
   </div>
   
   <!-- Employer Box -->
   <div class="cta-box cta-box-employer">
      <div class="cta-icon">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
         </svg>
      </div>
      <h3>I Am an Employer</h3>
      <p>Post jobs and access our online resume database to find the best talent for your company.</p>
      <a href="{{ route('employer.login') }}" class="cta-btn cta-btn-employer">
         Get Started
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
         </svg>
      </a>
   </div>
</div>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 60px auto; width: 90%; max-width: 1200px;">

@if($featuredCandidates && $featuredCandidates->count() > 0)
<!-- Featured Candidates Section -->
<section style="margin-top: 60px; margin-bottom: 60px; padding: 0 5%;">
   <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; width: 90%; max-width: 1200px; margin-left: auto; margin-right: auto;">
      <div>
         <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">Featured Candidates</h2>
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

   <div class="candidates-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; width: 90%; max-width: 1200px; margin: 0 auto; padding: 0; align-items: stretch;">
      @foreach($featuredCandidates->take(4) as $candidate)
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
      <div class="cand" style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); text-align: center; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%; min-height: 380px; width: auto;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0, 0, 0, 0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';" onclick="window.location.href='{{ route('candidates.show', $candidate->id) }}'">
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
</section>
@endif

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 60px auto; width: 90%; max-width: 1200px;">

@if($recommendedJobs && $recommendedJobs->count() > 0)
<!-- Recommended Jobs Section -->
<section style="margin-top: 60px; margin-bottom: 60px; padding: 0 5%;">
   <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; width: 90%; max-width: 1200px; margin-left: auto; margin-right: auto;">
      <div>
         <h2 class="section-title" style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0; color: #000; line-height: 1.2;">Recommended Jobs</h2>
         <p class="section-sub" style="margin: 0; color: #6b7280; font-size: 15px; line-height: 1.5;">Discover more opportunities tailored for you</p>
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
   
   <div class="jobs-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; width: 90%; max-width: 1200px; margin: 0 auto;">
      @foreach($recommendedJobs as $job)
      <div class="job-card" style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('jobs.show', $job->slug) }}'">
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
</section>

<style>
/* Job Card Responsive Styles */
@media (max-width: 768px) {
   .jobs-grid {
      grid-template-columns: 1fr !important;
      gap: 20px !important;
      width: 95% !important;
   }
   
   .job-card {
      padding: 16px !important;
   }
   
   .jc-top {
      flex-wrap: wrap !important;
   }
   
   .jc-tag {
      position: static !important;
      margin-top: 8px !important;
      width: fit-content !important;
   }
   
   .jc-title {
      font-size: 16px !important;
   }
   
   .jc-company {
      font-size: 13px !important;
   }
   
   .jc-salary {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 4px !important;
   }
}

.job-card:hover {
   box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
   transform: translateY(-4px) !important;
}

.job-card a:hover {
   color: #2772e8 !important;
}
</style>
@endif





   <!-- <section class="category-wrap seekerwrp popular-items mt-5">
      <div class="container">
         <div class="main_title">Job Seekers</div>
         <div class="cate_list">
         <ul class="owl-carousel jobs_list">
            @foreach($jobSeekers as $seeker)
            <li class="item wow fadeInUp">
              <div class="add-exp">
                  <div class="jobs-ad-card ">
                     <div class="category-job d-flex align-items-center">
                        <div class="job-icons">
                           <div class="seeker-avatar">{{ strtoupper(substr($seeker->seekerProfile->full_name ?? $seeker->name ?? 'U', 0, 1)) }}</div>
                        </div>
                        <div class="categery-name"> 
                           <h3>{{ $seeker->seekerProfile->full_name ?? $seeker->name }}
                           </h3>
                        </div>
                     </div> 
                  </div>
                  <div class="catebox">
                     <h3 class="mt-0 add-title"><a href="{{ route('candidates.show', $seeker->id) }}">{{ $seeker->seekerProfile->current_position ?? 'Job Seeker' }}</a></h3>
                      
                     <ul class="carinfo ad-features-parent">
                        <li>Experience  <span>{{ $seeker->seekerProfile->experience_years ?? 'N/A' }}</span></li>
                        <li>Commitment  <span>Full Time</span></li>
                         
                     </ul>
                     <div class="cartbx d-flex"><a href="#"><img src="{{ asset('images/location.svg') }}" alt="logo"> {{ $seeker->seekerProfile->city ?? 'UAE' }}</a>
                     </div>
                     <div class="price-ad">
                        <p>{{ $seeker->seekerProfile->expected_salary ?? 'Negotiable' }}</p>
                     </div>
                  </div>
               </div>
            </li>
            @endforeach

         </ul>
      </div> 
      <div class="text-center mt-4 mb-4">
         <a href="{{ route('candidates.index') }}" class="btn-browse-seekers">
            <i class="fas fa-users"></i> Browse All Job Seekers
         </a>
      </div> 
      </div> 
   </section> -->

@push('scripts')
<script>
$(document).ready(function() {
    // Featured Jobs Carousel - Fully Responsive
    if($('.featured-jobs-carousel').length > 0) {
        $('.featured-jobs-carousel').owlCarousel({
            loop: true,
            rewind: true,
            nav: true,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            margin: 15,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            smartSpeed: 600,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    margin: 10,
                    stagePadding: 10
                },
                480: {
                    items: 1,
                    nav: true,
                    margin: 10,
                    stagePadding: 15
                },
                576: {
                    items: 2,
                    nav: true,
                    margin: 12
                },
                768: {
                    items: 2,
                    nav: true,
                    margin: 15
                },
                992: {
                    items: 3,
                    nav: true,
                    margin: 15
                },
                1200: {
                    items: 4,
                    nav: true,
                    margin: 15
                }
            }
        });
    }
    
    // Featured Candidates Carousel - Fully Responsive
    if($('.featured-candidates-carousel').length > 0) {
        var candidatesCarousel = $('.featured-candidates-carousel').owlCarousel({
            loop: true,
            rewind: true,
            nav: true,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            margin: 20,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            smartSpeed: 600,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    margin: 10,
                    stagePadding: 10
                },
                480: {
                    items: 1,
                    nav: true,
                    margin: 10,
                    stagePadding: 15
                },
                576: {
                    items: 2,
                    nav: true,
                    margin: 15
                },
                768: {
                    items: 2,
                    nav: true,
                    margin: 18
                },
                992: {
                    items: 3,
                    nav: true,
                    margin: 20
                },
                1200: {
                    items: 4,
                    nav: true,
                    margin: 20
                }
            }
        });
        
        // Fix width issues with jQuery
        function fixCandidatesCarouselWidth() {
            var $carousel = $('.featured-candidates-carousel');
            var $wrapper = $('.featured-candidates-carousel-wrapper');
            var $container = $('.featured-candidates-section .container');
            
            if($carousel.length > 0 && $wrapper.length > 0 && $container.length > 0) {
                // Get container width
                var containerWidth = $container.width();
                
                // Set wrapper and carousel width to match container
                $wrapper.css({
                    'max-width': containerWidth + 'px',
                    'width': '100%',
                    'margin': '0 auto'
                });
                
                $carousel.css({
                    'max-width': '100%',
                    'width': '100%'
                });
                
                // Fix owl-stage-outer width
                $carousel.find('.owl-stage-outer').css({
                    'max-width': '100%',
                    'width': '100%'
                });
                
                // Trigger refresh
                if(candidatesCarousel && typeof candidatesCarousel.trigger === 'function') {
                    candidatesCarousel.trigger('refresh.owl.carousel');
                }
            }
        }
        
        // Fix width on load
        setTimeout(function() {
            fixCandidatesCarouselWidth();
        }, 100);
        
        // Fix width on window resize
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                fixCandidatesCarouselWidth();
            }, 250);
        });
        
        // Fix width after carousel is initialized
        $('.featured-candidates-carousel').on('initialized.owl.carousel', function() {
            fixCandidatesCarouselWidth();
        });
        
        // Also fix on refresh
        $('.featured-candidates-carousel').on('refreshed.owl.carousel', function() {
            fixCandidatesCarouselWidth();
        });
    }
});
</script>
<style>
/* Owl Carousel Navigation Buttons - Mobile Responsive */
.owl-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
}

.owl-nav button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #1a1a1a !important;
    color: #ffffff !important;
    border: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
}

.owl-nav button:hover {
    background: #1a1a1a !important;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
}

.owl-nav button:active {
    transform: scale(0.95);
}

.owl-nav button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Mobile Responsive Adjustments */
@media (max-width: 576px) {
    .owl-nav {
        margin-top: 15px;
    }
    
    .owl-nav button {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .featured-jobs-grid .owl-stage-outer,
    .featured-candidates-carousel-wrapper .owl-stage-outer {
        padding: 0 5px;
    }
}

@media (max-width: 480px) {
    .owl-nav button {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .featured-jobs-grid .owl-item,
    .featured-candidates-carousel-wrapper .owl-item {
        padding: 0 5px !important;
    }
}

/* Prevent horizontal scroll on carousel */
.featured-jobs-grid .owl-stage-outer,
.featured-candidates-carousel-wrapper .owl-stage-outer {
    overflow: hidden;
    width: 100%;
}

.featured-jobs-grid .owl-stage,
.featured-candidates-carousel-wrapper .owl-stage {
    display: flex;
    align-items: stretch;
}

.featured-jobs-grid .owl-item,
.featured-candidates-carousel-wrapper .owl-item {
    display: flex;
    height: auto;
}

.featured-job-card,
.featured-candidate-card {
    width: 280px !important;
    height: 100%;
}

/* Mobile - Full Width */
@media (max-width: 991.98px) {
    .featured-job-card,
    .featured-candidate-card {
        width: 100% !important;
    }
}

/* Web/Desktop - Fixed Width */
@media (min-width: 992px) {
    .featured-job-card,
    .featured-candidate-card {
        width: 280px !important;
    }
}
</style>
@endpush
@endsection

