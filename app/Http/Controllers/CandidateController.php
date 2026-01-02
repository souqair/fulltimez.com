<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobApplication;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('email_verified_at')
            ->whereHas('seekerProfile', function($q) {
                $q->where('approval_status', 'approved'); // Only show approved resumes
            });

        // Search filter - name or position
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('seekerProfile', function($sq) use ($search) {
                      $sq->where('full_name', 'like', '%' . $search . '%')
                        ->orWhere('current_position', 'like', '%' . $search . '%');
                  });
            });
        }

        // Experience filter
        if ($request->filled('experience')) {
            $experience = $request->experience;
            $query->whereHas('seekerProfile', function($q) use ($experience) {
                if (strpos($experience, '-') !== false) {
                    [$min, $max] = explode('-', $experience);
                    // Extract years from experience string like "3-5 years"
                    $q->where(function($subQ) use ($min, $max) {
                        $subQ->where('experience_years', 'like', $min . '-%')
                            ->orWhere('experience_years', 'like', $max . '-%')
                            ->orWhere('experience_years', 'like', '%' . $min . '%')
                            ->orWhere('experience_years', 'like', '%' . $max . '%');
                    });
                } else {
                    $q->where('experience_years', 'like', '%' . $experience . '%');
                }
            });
        }

        // Expected Salary filter
        if ($request->filled('salary')) {
            $salaryRange = $request->salary;
            $query->whereHas('seekerProfile', function($q) use ($salaryRange) {
                if ($salaryRange === '15000+') {
                    // Check for salary >= 15000
                    $q->where(function($subQ) {
                        $subQ->where('expected_salary', 'like', '15000%')
                            ->orWhere('expected_salary', 'like', '%15000%')
                            ->orWhere('expected_salary', 'like', '2%')
                            ->orWhere('expected_salary', 'like', '3%')
                            ->orWhere('expected_salary', 'like', '4%')
                            ->orWhere('expected_salary', 'like', '5%')
                            ->orWhere('expected_salary', 'like', '%16000%')
                            ->orWhere('expected_salary', 'like', '%20000%');
                    });
                } elseif (strpos($salaryRange, '-') !== false) {
                    [$min, $max] = explode('-', $salaryRange);
                    $q->where(function($subQ) use ($min, $max) {
                        $subQ->where('expected_salary', 'like', $min . '%')
                            ->orWhere('expected_salary', 'like', $max . '%')
                            ->orWhere('expected_salary', 'like', '%' . $min . '%')
                            ->orWhere('expected_salary', 'like', '%' . $max . '%');
                    });
                } else {
                    $q->where('expected_salary', 'like', '%' . $salaryRange . '%');
                }
            });
        }

        // City filter
        if ($request->filled('city')) {
            $city = trim($request->city);
            $query->whereHas('seekerProfile', function($q) use ($city) {
                $q->where('city', '=', $city)
                  ->orWhere('city', 'like', '%' . $city . '%');
            });
        }

        // Country filter
        if ($request->filled('country')) {
            $country = trim($request->country);
            $query->whereHas('seekerProfile', function($q) use ($country) {
                $q->where('country', '=', $country)
                  ->orWhere('country', 'like', '%' . $country . '%');
            });
        }

        // Nationality filter
        if ($request->filled('nationality')) {
            $query->whereHas('seekerProfile', function($q) use ($request) {
                $q->where('nationality', $request->nationality);
            });
        }

        $candidates = $query->latest()->paginate(12)->withQueryString();

        // Get Featured Resumes (featured, approved, and verified seekers with complete profiles)
        $featuredCandidates = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('email_verified_at')
            ->whereHas('seekerProfile', function($q) {
                $q->where('approval_status', 'approved')
                  ->where('is_featured', true)
                  ->where(function($subQ) {
                      $subQ->whereNull('featured_expires_at')
                           ->orWhere('featured_expires_at', '>', now());
                  })
                  ->whereNotNull('full_name')
                  ->whereNotNull('current_position')
                  ->whereNotNull('expected_salary');
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get Featured candidate IDs to exclude from Recommended
        $featuredCandidateIds = $featuredCandidates->pluck('id')->toArray();

        // Get Recommended Resumes (not featured, but approved and verified, excluding featured ones)
        $recommendedCandidates = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->where('status', 'active')
            ->where('is_approved', true)
            ->whereNotNull('email_verified_at')
            ->whereHas('seekerProfile', function($q) {
                $q->where('approval_status', 'approved')
                  ->where(function($subQ) {
                      // Exclude active featured candidates: get only non-featured OR featured but expired
                      $subQ->where('is_featured', false)
                           ->orWhere(function($expiredQ) {
                               // Featured but expired (has expiry date and it's passed)
                               $expiredQ->where('is_featured', true)
                                       ->whereNotNull('featured_expires_at')
                                       ->where('featured_expires_at', '<=', now());
                           });
                  })
                  ->whereNotNull('full_name')
                  ->whereNotNull('current_position')
                  ->whereNotNull('expected_salary');
            })
            ->when(!empty($featuredCandidateIds), function($q) use ($featuredCandidateIds) {
                // Double check: exclude featured candidates by ID (active featured ones)
                $q->whereNotIn('id', $featuredCandidateIds);
            })
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get countries and cities for filter dropdowns
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)
            ->when($request->filled('country'), function($q) use ($request) {
                $q->whereHas('country', function($cq) use ($request) {
                    $cq->where('name', 'like', '%' . $request->country . '%');
                });
            })
            ->orderBy('name')
            ->get();

        return view('candidates.index', compact('candidates', 'featuredCandidates', 'recommendedCandidates', 'countries', 'cities'));
    }

    public function show($id)
    {
        $candidate = User::whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with(['seekerProfile', 'educationRecords', 'experienceRecords', 'certificates'])
            ->findOrFail($id);

        $viewer = auth()->user();
        $canViewContact = false;

        if ($viewer) {
            if ($viewer->isAdmin()) {
                $canViewContact = true;
            } elseif ($viewer->isSeeker() && $viewer->id === $candidate->id) {
                $canViewContact = true;
            } elseif ($viewer->isEmployer()) {
                $canViewContact = JobApplication::where('seeker_id', $candidate->id)
                    ->whereHas('job', function($q) use ($viewer) {
                        $q->where('employer_id', $viewer->id);
                    })
                    ->exists();
            }
        }

        return view('candidates.show', compact('candidate', 'canViewContact'));
    }
}
