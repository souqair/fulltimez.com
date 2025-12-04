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
    color: #007bff !important;
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
    color: #2773e8 !important;
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
    color: #2773e8 !important;
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
    background: #2773e8 !important;
    color: #ffffff !important;
    border-color: #2773e8 !important;
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
    background: #2773e8 !important;
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
    background: #2773e8;
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
    background: #2773e8 !important;
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
    border-color: #2773e8 !important;
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
    color: #2773e8 !important;
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
    .hero-title {
        font-size: 32px !important;
    }
    
    .hero-description {
        font-size: 16px !important;
    }
    
    .hero-search-bar {
        padding: 16px !important;
    }
    
    .hero-search-bar .row.g-0 > div {
        border-right: none !important;
        border-bottom: 1px solid #e5e7eb !important;
        border-radius: 0 !important;
    }
    
    .hero-search-bar .row.g-0 > div:first-child {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .hero-search-bar .row.g-0 > div:last-child {
        border-bottom: none !important;
        border-radius: 0 0 12px 12px !important;
    }
    
    .hero-search-bar .row.g-0 > div button {
        border-radius: 0 0 12px 12px !important;
        width: 100% !important;
    }
    
    .stat-number {
        font-size: 32px !important;
    }
    
    .stat-label {
        font-size: 14px !important;
    }
    
    .cta-title {
        font-size: 24px !important;
    }
    
    .cta-description {
        font-size: 14px !important;
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

    
</style>
@endpush

@section('hero')
<!-- Hero Section -->
<section class="hero-section" style="background: #ffffff; padding: 80px 0 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="hero-title" style="font-size: 48px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; line-height: 1.2;">
                    Empowering Your Career Journey
                </h1>
                <p class="hero-description" style="font-size: 18px; color: #6b7280; max-width: 800px; margin: 0 auto 40px; line-height: 1.6;">
                    Whether you're searching for your first job or your next big opportunity, we connect you with employers who value your talent.
                </p>
            </div>
        </div>
        
        <!-- Hero Search Bar -->
        <div class="row">
            <div class="col-12">
                <div class="hero-search-bar" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); max-width: 1100px; margin: 0 auto;">
                    <form action="{{ route('jobs.index') }}" method="GET" class="hero-search-form">
                        <div class="row g-0 align-items-center" style="background: #ffffff; border-radius: 12px;">
                            <div class="col-md-4" style="position: relative;">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); z-index: 10; color: #6b7280;">
                                    <i class="fas fa-building" style="font-size: 16px;"></i>
                                </div>
                                <input type="text" class="form-control" name="title" placeholder="e.g. Developer, Designer" value="{{ request('title') }}" style="padding: 16px 16px 16px 45px; border: none; border-right: 1px solid #e5e7eb; border-radius: 12px 0 0 12px; font-size: 15px; background: transparent;">
                            </div>
                            <div class="col-md-4" style="position: relative;">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); z-index: 10; color: #6b7280;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 16px;"></i>
                                </div>
                                <input type="text" class="form-control" name="location" placeholder="City or Country" value="{{ request('location') }}" style="padding: 16px 16px 16px 45px; border: none; border-right: 1px solid #e5e7eb; font-size: 15px; background: transparent;">
                            </div>
                            <div class="col-md-3" style="position: relative;">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); z-index: 10; color: #6b7280;">
                                    <i class="fas fa-briefcase" style="font-size: 16px;"></i>
                                </div>
                                <select class="form-control" name="category" style="padding: 16px 16px 16px 45px; border: none; border-right: 1px solid #e5e7eb; font-size: 15px; background: transparent; appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><polyline points=\'6 9 12 15 18 9\'></polyline></svg>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; padding-right: 40px;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100" style="padding: 16px; background: #1a1a1a; border: none; border-radius: 0 12px 12px 0; color: #ffffff; font-weight: 600; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-search" style="font-size: 18px;"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="statistics-section" style="background: #ffffff; padding: 60px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                <div class="stat-item">
                    <h2 class="stat-number" style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">10,000+</h2>
                    <p class="stat-label" style="font-size: 16px; color: #6b7280; margin: 0;">Active Jobs</p>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                <div class="stat-item">
                    <h2 class="stat-number" style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">5,000+</h2>
                    <p class="stat-label" style="font-size: 16px; color: #6b7280; margin: 0;">Companies</p>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                <div class="stat-item">
                    <h2 class="stat-number" style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">50,000+</h2>
                    <p class="stat-label" style="font-size: 16px; color: #6b7280; margin: 0;">Candidates</p>
                </div>
            </div>
            <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                <div class="stat-item">
                    <h2 class="stat-number" style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">95%</h2>
                    <p class="stat-label" style="font-size: 16px; color: #6b7280; margin: 0;">Success Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')






   <!-- Featured Jobs Section -->
   <section class="category-wrap jobwrp popular-items mt-5">
      <div class="container">
         <div class="d-flex justify-content-between align-items-center mb-4" style="flex-wrap: wrap; gap: 15px;">
            <div>
               <h2 class="main_title" style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Featured Jobs</h2>
               <p style="font-size: 16px; color: #6b7280; margin: 0;">Discover exciting opportunities from top employers.</p>
            </div>
            <div>
               <a href="{{ route('jobs.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #1a1a1a; text-decoration: none; font-weight: 600; font-size: 16px;">
                  Browse All Jobs <i class="fas fa-arrow-right"></i>
               </a>
            </div>
         </div>
         <div class="featured-jobs-grid">
            <ul class="owl-carousel jobs_list featured-jobs-carousel">
            @foreach($featuredJobs as $job)
            <li class="item wow fadeInUp">
                  <div class="featured-job-card" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; position: relative;">
                     <!-- Category Badge at Top Right -->
                     <div style="position: absolute; top: 20px; right: 20px;">
                        <span style="display: inline-block; padding: 6px 12px; background: #f3f4f6; color: #374151; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                           {{ optional($job->category)->name ?? 'N/A' }}
                        </span>
                     </div>
                     
                     <!-- Building Icon at Top Left -->
                     <div style="margin-bottom: 16px;">
                        <div style="width: 48px; height: 48px; background: #f3f4f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                           <i class="fas fa-building" style="font-size: 24px; color: #6b7280;"></i>
                        </div>
                     </div>
                     
                     <!-- Job Title -->
                     <div style="margin-bottom: 12px;">
                        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1a1a1a; line-height: 1.4;">
                           <a href="{{ route('jobs.show', $job->slug) }}" style="color: #1a1a1a; text-decoration: none;">{{ $job->title }}</a>
                        </h3>
                     </div>
                     
                     <!-- Company Name -->
                     <div style="margin-bottom: 16px;">
                        <p style="margin: 0; font-size: 15px; color: #6b7280; font-weight: 500;">
                           {{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}
                        </p>
                     </div>
                     
                     <!-- Location -->
                     <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; color: #6b7280; font-size: 14px;">
                        <i class="fas fa-map-marker-alt" style="font-size: 14px;"></i>
                        <span>{{ $job->location_city }}{{ $job->location_country ? ', ' . $job->location_country : '' }}</span>
                     </div>
                     
                     <!-- Employment Type and Experience -->
                     <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px; color: #6b7280; font-size: 14px;">
                        <i class="far fa-clock" style="font-size: 14px;"></i>
                        <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }} • {{ $job->experience_years ?? 'N/A' }} Years Experience</span>
                     </div>
                     
                     <!-- Salary -->
                     <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid #f3f4f6;">
                        <div style="display: flex; flex-direction: column;">
                           @if(!empty($job->salary_min) && !empty($job->salary_max))
                              <span style="font-size: 18px; font-weight: 700; color: #1a1a1a;">
                                 {{ $job->salary_currency ?? 'AED' }} {{ number_format((float)$job->salary_min) }} - {{ number_format((float)$job->salary_max) }}
                              </span>
                              <span style="font-size: 13px; color: #6b7280; margin-top: 2px;">
                                 / {{ ucfirst($job->salary_period ?? 'Monthly') }}
                              </span>
                           @else
                              <span style="font-size: 16px; font-weight: 600; color: #6b7280;">Negotiable</span>
                           @endif
                        </div>
                     </div>
                  </div>
            </li>
            @endforeach
         </ul>
      </div> 
      </div> 
   </section>
 
<div class="ads_ text-center mb-4"><p style="font-size: 12px; color: #6b7280; margin: 0; padding: 10px 0;">ADVERTISEMENT</p></div>
<!-- Call to Action Section: Jobseeker & Employer -->
<section class="cta-section mt-5 mb-5">
    <div class="container">
        <div class="row g-4">
            <!-- Job Seeker Card -->
            <div class="col-lg-6 col-md-6">
                <div class="cta-card jobseeker-card" style="background: #1a1a1a; border-radius: 16px; padding: 40px; min-height: 350px; display: flex; flex-direction: column; position: relative; overflow: hidden;">
                    <div class="cta-icon" style="position: absolute; top: 30px; left: 30px; width: 50px; height: 50px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-building" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                    <div class="cta-content" style="margin-top: auto; color: #ffffff;">
                        <h2 class="cta-title" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 20px;">I Am a Job Seeker</h2>
                        <p class="cta-description" style="font-size: 16px; color: rgba(255, 255, 255, 0.9); margin-bottom: 30px; line-height: 1.6;">
                            Create your professional resume with our online builder and start applying for the best jobs.
                        </p>
                        <a href="{{ route('jobseeker.login') }}" class="cta-btn" style="display: inline-flex; align-items: center; gap: 10px; background: #ffffff; color: #1a1a1a; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.3s ease;">
                            Get Started <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Employer Card -->
            <div class="col-lg-6 col-md-6">
                <div class="cta-card employer-card" style="background: #ffffff; border: 2px solid #e5e7eb; border-radius: 16px; padding: 40px; min-height: 350px; display: flex; flex-direction: column; position: relative; overflow: hidden;">
                    <div class="cta-icon" style="position: absolute; top: 30px; left: 30px; width: 50px; height: 50px; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 24px; color: #1a1a1a;"></i>
                    </div>
                    <div class="cta-content" style="margin-top: auto; color: #1a1a1a;">
                        <h2 class="cta-title" style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px;">I Am an Employer</h2>
                        <p class="cta-description" style="font-size: 16px; color: #6b7280; margin-bottom: 30px; line-height: 1.6;">
                            Post jobs and access our online resume database to find the best talent for your company.
                        </p>
                        <a href="{{ route('employer.login') }}" class="cta-btn" style="display: inline-flex; align-items: center; gap: 10px; background: #1a1a1a; color: #ffffff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.3s ease;">
                            Get Started <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($featuredCandidates && $featuredCandidates->count() > 0)
<!-- Featured Candidates Section -->
<section class="featured-candidates-section mt-5 mb-5">
<div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" style="flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 class="featured-candidates-title" style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Featured Candidates</h2>
                <p class="featured-candidates-subtitle" style="font-size: 16px; color: #6b7280; margin: 0;">Connect with top talent ready for their next opportunity.</p>
            </div>
            <div>
                <a href="{{ route('candidates.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #1a1a1a; text-decoration: none; font-weight: 600; font-size: 16px;">
                    View All Candidates <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="featured-candidates-carousel-wrapper">
            <ul class="owl-carousel jobs_list featured-candidates-carousel">
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
                <li class="item wow fadeInUp">
                    <div class="featured-candidate-card" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: all 0.3s ease;">
                        <!-- Profile Picture with Star Badge -->
                        <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: #2772e8; display: flex; align-items: center; justify-content: center; font-size: 32px; color: #ffffff; font-weight: 600; position: relative;">
                                @if($hasImage && $avatarPath)
                                    <img src="{{ $avatarPath }}" alt="{{ $displayName }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                    {{ $initial }}
                                @endif
                                <div style="position: absolute; top: -5px; right: -5px; width: 24px; height: 24px; background: #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #ffffff;">
                                    <i class="fas fa-star" style="font-size: 12px; color: #ffffff;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Candidate Info -->
                        <div class="candidate-card-body" style="text-align: left;">
                            <h5 class="candidate-name" style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">{{ $candidate->seekerProfile->full_name ?? $candidate->name }}</h5>
                            
                            <!-- Job Title -->
                            <p class="candidate-profession" style="font-size: 14px; color: #6b7280; margin-bottom: 12px;">{{ $candidate->seekerProfile->current_position ?? 'Job Seeker' }}</p>
                            
                            <!-- Location -->
                            <div class="candidate-location" style="display: flex; align-items: center; gap: 6px; color: #6b7280; font-size: 13px; margin-bottom: 16px;">
                                <i class="fas fa-map-marker-alt" style="font-size: 12px;"></i>
                                <span>{{ $candidate->seekerProfile->city ?? 'UAE' }}, {{ $candidate->seekerProfile->country ?? 'UAE' }}</span>
                            </div>
                            
                            <!-- Skills Tags -->
                            @php
                                $skills = [];
                                if($candidate->seekerProfile && $candidate->seekerProfile->skills) {
                                    $skillsData = is_string($candidate->seekerProfile->skills) ? json_decode($candidate->seekerProfile->skills, true) : $candidate->seekerProfile->skills;
                                    if(is_array($skillsData)) {
                                        $skills = array_slice($skillsData, 0, 3);
                                    }
                                }
                            @endphp
                            @if(count($skills) > 0)
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px;">
                                @foreach($skills as $skill)
                                    <span style="display: inline-block; padding: 4px 10px; background: #f3f4f6; color: #374151; border-radius: 6px; font-size: 11px; font-weight: 500;">{{ $skill }}</span>
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Experience and Rating -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                <div style="font-size: 13px; color: #6b7280;">
                                    {{ $candidate->seekerProfile->experience_years ?? 'N/A' }} Years
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 14px;"></i>
                                    <span style="font-size: 14px; font-weight: 600; color: #1a1a1a;">4.9</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endif

@if($recommendedJobs && $recommendedJobs->count() > 0)
<div class="jobs-wrap">
   <div class="container">
       <div class="title title_center">
         <h1>Recommended Jobs</h1>
      </div>
      <div class="row">
         

         <div class="col-lg-12">
<div class="row">
@foreach($recommendedJobs as $job)
<div class="col-lg-4 col-md-6">
<div class="jobs" style="height: 100%; display: flex; flex-direction: column;">
   <div class="job-content" style="flex: 1;">
      <div class="jobdate">{{ $job->created_at->format('d/m/y') }}</div>
      <p class="m-0">{{ optional($job->employer->employerProfile)->company_name ?? 'Company' }}</p>
   <h3><a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a></h3>
   <ul class="tags">
              @php
                  $skills = null;
                  if ($job->skills_required) {
                      if (is_array($job->skills_required)) {
                          $skills = $job->skills_required;
                      } elseif (is_string($job->skills_required)) {
                          $decoded = json_decode($job->skills_required, true);
                          $skills = is_array($decoded) ? $decoded : null;
                      }
                  }
              @endphp
              @if($skills && is_array($skills) && count($skills) > 0)
                  @foreach(array_slice($skills, 0, 4) as $skill)
                      @if(!empty($skill))
                          <li><a href="#">{{ $skill }}</a></li>
                      @endif
                  @endforeach
              @endif
            </ul>
         </div>

         <div class="d-flex align-items-center justify-content-between">
         <div class="job_price">AED {{ number_format((float)($job->salary_min ?? 250)) }}/{{ $job->salary_period ?? 'hr' }} <span>{{ $job->location_city }}</span></div>
         <div class="readmore m-0"><a href="{{ route('jobs.show', $job->slug) }}">Details</a></div>
      </div>

</div>
</div>
@endforeach
</div>
</div>
<div class="text-center mt-4 mb-4">
   <a href="{{ route('jobs.index') }}" class="btn-browse-jobs">
      <i class="fas fa-search"></i> Browse All Jobs
   </a>
</div>

</div>

                        </div>
                        </div>
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
    background: #007bff !important;
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
    background: #0056b3 !important;
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

