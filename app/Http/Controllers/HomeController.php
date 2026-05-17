<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use App\Models\JobCategory;
use App\Models\Country;
use App\Models\City;
use App\Services\CountryContext;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(CountryContext $countryContext)
    {
        $countryAliases = $countryContext->aliases();

        $basePublishedQuery = JobPosting::where('status', 'published')
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->when(! empty($countryAliases), function($q) use ($countryAliases) {
                $q->whereIn('location_country', $countryAliases);
            })
            ->with(['employer.employerProfile', 'category', 'employmentType', 'salaryCurrency', 'salaryPeriod', 'experienceYear']);

        // Get featured jobs (validated featured ads only)
        $featuredJobs = (clone $basePublishedQuery)
            ->featured()
            ->orderBy('featured_expires_at', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(8)
            ->get();

        // Get recommended jobs (ads not currently featured)
        $recommendedJobs = (clone $basePublishedQuery)
            ->notFeatured()
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Fallback: if still empty, pull latest published jobs (without featured requirement)
        if ($recommendedJobs->isEmpty()) {
            $recommendedJobs = (clone $basePublishedQuery)
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get();
        }

        $baseSeekerQuery = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('email_verified_at')
            ->whereHas('seekerProfile', function($q) use ($countryAliases) {
                $q->where('approval_status', 'approved');
                if (! empty($countryAliases)) {
                    $q->whereIn('country', $countryAliases);
                }
            });

        $jobSeekers = (clone $baseSeekerQuery)
            ->latest()
            ->take(10)
            ->get();

        // Get featured job seeker for the profile section
        $featuredJobSeeker = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->whereHas('seekerProfile', function($q) use ($countryAliases) {
                $q->whereNotNull('full_name');
                if (! empty($countryAliases)) {
                    $q->whereIn('country', $countryAliases);
                }
            })
            ->latest()
            ->first();

        // Get featured candidates (featured, approved, and verified seekers with complete profiles)
        $featuredCandidates = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('email_verified_at')
            ->whereHas('seekerProfile', function($q) use ($countryAliases) {
                $q->where('approval_status', 'approved')
                  ->where('is_featured', true)
                  ->where('featured_expires_at', '>', now())
                  ->whereNotNull('full_name');
                if (! empty($countryAliases)) {
                    $q->whereIn('country', $countryAliases);
                }
            })
            ->latest()
            ->take(4)
            ->get();


        // Get categories for search dropdown
        $categories = JobCategory::where('is_active', true)->orderBy('name')->get();

        // Get countries and cities for search dropdown
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)
            ->when(! empty($countryAliases), function($q) use ($countryAliases) {
                $q->whereHas('country', function($cq) use ($countryAliases) {
                    $cq->whereIn('name', $countryAliases);
                });
            })
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredJobs', 'recommendedJobs', 'jobSeekers', 'featuredJobSeeker', 'featuredCandidates', 'categories', 'countries', 'cities'));
    }
}
