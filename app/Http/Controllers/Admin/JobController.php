<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\JobCategory;
use App\Models\EmploymentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with(['category', 'employer.employerProfile', 'employmentType', 'experienceLevel', 'experienceYear', 'educationLevel', 'salaryCurrency', 'salaryPeriod']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location_city', 'like', "%{$search}%")
                  ->orWhere('location_state', 'like', "%{$search}%")
                  ->orWhere('location_country', 'like', "%{$search}%");
            });
        }

        // Company filter
        if ($request->filled('company')) {
            $query->whereHas('employer.employerProfile', function($q) use ($request) {
                $q->where('company_name', 'like', "%{$request->company}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // OEP Pakistan filter
        if ($request->filled('is_oep_pakistan')) {
            $isOep = $request->is_oep_pakistan;
            if ($isOep === '1') {
                $query->where('is_oep_pakistan', 1);
            } elseif ($isOep === '0') {
                $query->where(function($q) {
                    $q->where('is_oep_pakistan', 0)
                      ->orWhereNull('is_oep_pakistan');
                });
            }
        }

        $perPage = $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;
        
        $jobs = $query->orderBy('id', 'desc')->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => JobPosting::count(),
            'published' => JobPosting::where('status', 'published')->count(),
            'pending' => JobPosting::where('status', 'pending')->count(),
            'featured_pending' => JobPosting::where('status', 'featured_pending')->count(),
            'draft' => JobPosting::where('status', 'draft')->count(),
            'closed' => JobPosting::where('status', 'closed')->count(),
        ];

        return view('admin.jobs.index', compact('jobs', 'stats'));
    }

    public function create()
    {
        $categories = JobCategory::where('is_active', true)->get();
        $employmentTypes = EmploymentType::where('is_active', true)->orderBy('name')->get();
        $experienceLevels = \App\Models\ExperienceLevel::where('is_active', true)->orderBy('name')->get();
        $experienceYears = \App\Models\ExperienceYear::where('is_active', true)->orderBy('sort_order')->get();
        $educationLevels = \App\Models\EducationLevel::where('is_active', true)->orderBy('name')->get();
        $salaryCurrencies = \App\Models\SalaryCurrency::where('is_active', true)->orderBy('code')->get();
        $salaryPeriods = \App\Models\SalaryPeriod::where('is_active', true)->orderBy('name')->get();
        $employers = User::where('role_id', 2)->with('employerProfile')->get();
        
        // Get all countries (admin can post in any country)
        $countries = \App\Models\Country::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.jobs.create', compact('categories', 'employmentTypes', 'experienceLevels', 'experienceYears', 'educationLevels', 'salaryCurrencies', 'salaryPeriods', 'employers', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:job_categories,id',
            'employer_id' => 'required|exists:users,id',
            'location_city' => 'required|string|max:255',
            'location_state' => 'nullable|string|max:255',
            'location_country' => 'required|string|max:255',
            'is_oep_pakistan' => 'nullable|boolean',
            'oep_permission_number' => 'required_if:is_oep_pakistan,1|nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency_id' => 'nullable|exists:salary_currencies,id',
            'salary_period_id' => 'nullable|exists:salary_periods,id',
            'employment_type_id' => 'required|exists:employment_types,id',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'experience_year_id' => 'required|exists:experience_years,id',
            'education_level_id' => 'required|exists:education_levels,id',
            'salary_type' => 'required|in:fixed,negotiable,based_on_experience,salary_plus_commission',
            'gender' => 'required|in:male,female,any',
            'age_from' => 'nullable|integer|min:18|max:100',
            'age_to' => 'nullable|integer|min:18|max:100|gte:age_from',
            'age_below' => 'nullable|integer|min:18|max:100',
            'skills_required' => 'nullable|string',
            'application_deadline' => 'nullable|date|after:today',
            'status' => 'required|in:draft,published,closed',
        ]);

        $jobData = $request->all();
        
        // Handle skills_required as JSON
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $jobData['skills_required'] = json_encode($skills);
        }
        
        // Validate age fields
        if ((!empty($jobData['age_from']) || !empty($jobData['age_to'])) && !empty($jobData['age_below'])) {
            return redirect()->back()
                ->withErrors(['age_below' => 'Please use either age range (from-to) OR age below, not both.'])
                ->withInput();
        }
        
        // Generate slug
        $jobData['slug'] = \Illuminate\Support\Str::slug($jobData['title']) . '-' . time();
        
        // Set default values
        $jobData['priority'] = $jobData['priority'] ?? 'normal';
        $jobData['ad_type'] = $jobData['ad_type'] ?? 'recommended';
        
        // If published, set published_at
        if ($jobData['status'] === 'published') {
            $jobData['published_at'] = now();
        }

        $job = JobPosting::create($jobData);

        // If job is published immediately, notify employer and matching jobseekers
        if ($job->status === 'published') {
            if ($job->employer) {
                $expiresText = $job->expires_at ? $job->expires_at->format('F j, Y') : null;
                $job->employer->notify(new \App\Notifications\JobPublished(
                    $job->id,
                    $job->title,
                    $expiresText
                ));
            }
            $this->notifyMatchingJobseekers($job);
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job created successfully.');
    }

    public function show(JobPosting $job)
    {
        $job->load(['category', 'employer.employerProfile', 'applications.seeker.seekerProfile', 'employmentType', 'experienceLevel', 'experienceYear', 'educationLevel', 'salaryCurrency', 'salaryPeriod']);
        
        return view('admin.jobs.show', compact('job'));
    }

    public function edit(JobPosting $job)
    {
        $categories = JobCategory::where('is_active', true)->get();
        $employmentTypes = EmploymentType::where('is_active', true)->orderBy('name')->get();
        $experienceLevels = \App\Models\ExperienceLevel::where('is_active', true)->orderBy('name')->get();
        $experienceYears = \App\Models\ExperienceYear::where('is_active', true)->orderBy('sort_order')->get();
        $educationLevels = \App\Models\EducationLevel::where('is_active', true)->orderBy('name')->get();
        $salaryCurrencies = \App\Models\SalaryCurrency::where('is_active', true)->orderBy('code')->get();
        $salaryPeriods = \App\Models\SalaryPeriod::where('is_active', true)->orderBy('name')->get();
        $employers = User::where('role_id', 2)->with('employerProfile')->get();
        
        // Get all countries (admin can post in any country)
        $countries = \App\Models\Country::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.jobs.edit', compact('job', 'categories', 'employmentTypes', 'experienceLevels', 'experienceYears', 'educationLevels', 'salaryCurrencies', 'salaryPeriods', 'employers', 'countries'));
    }

    public function update(Request $request, JobPosting $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:job_categories,id',
            'employer_id' => 'required|exists:users,id',
            'location_city' => 'required|string|max:255',
            'location_state' => 'nullable|string|max:255',
            'location_country' => 'required|string|max:255',
            'is_oep_pakistan' => 'nullable|boolean',
            'oep_permission_number' => 'required_if:is_oep_pakistan,1|nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency_id' => 'nullable|exists:salary_currencies,id',
            'salary_period_id' => 'nullable|exists:salary_periods,id',
            'employment_type_id' => 'required|exists:employment_types,id',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'experience_year_id' => 'required|exists:experience_years,id',
            'education_level_id' => 'required|exists:education_levels,id',
            'salary_type' => 'required|in:fixed,negotiable,based_on_experience,salary_plus_commission',
            'gender' => 'required|in:male,female,any',
            'age_from' => 'nullable|integer|min:18|max:100',
            'age_to' => 'nullable|integer|min:18|max:100|gte:age_from',
            'age_below' => 'nullable|integer|min:18|max:100',
            'skills_required' => 'nullable|string',
            'status' => 'required|in:draft,published,closed',
        ]);

        $jobData = $request->all();
        
        // Handle skills_required as JSON
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $jobData['skills_required'] = json_encode($skills);
        }
        
        // Validate age fields
        if ((!empty($jobData['age_from']) || !empty($jobData['age_to'])) && !empty($jobData['age_below'])) {
            return redirect()->back()
                ->withErrors(['age_below' => 'Please use either age range (from-to) OR age below, not both.'])
                ->withInput();
        }
        
        // If status changed to published, set published_at
        if ($job->status !== 'published' && $jobData['status'] === 'published') {
            $jobData['published_at'] = now();
        }

        $oldStatus = $job->status;
        $job->update($jobData);

        // If job status changed to published, notify employer and matching jobseekers
        if ($oldStatus !== 'published' && $job->status === 'published') {
            if ($job->employer) {
                $expiresText = $job->expires_at ? $job->expires_at->format('F j, Y') : null;
                $job->employer->notify(new \App\Notifications\JobPublished(
                    $job->id,
                    $job->title,
                    $expiresText
                ));
            }
            $this->notifyMatchingJobseekers($job);
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function approve(JobPosting $job, Request $request)
    {
        $approveAsRecommended = $request->has('as_recommended') && $request->as_recommended == '1';
        $wasFeaturedPending = $job->status === 'featured_pending';
        $priority = $job->priority ?? 'normal';
        $adType = $job->ad_type ?? null;

        // If admin wants to approve featured request as recommended
        if ($wasFeaturedPending && $approveAsRecommended) {
            $expiresAt = now()->addDays(7);
            $job->update([
                'status' => 'published',
                'published_at' => now(),
                'expires_at' => $expiresAt,
                'featured_expires_at' => null,
                'ad_type' => 'recommended',
                'priority' => 'normal',
                'is_premium' => false,
                'premium_expires_at' => null,
            ]);

            // Notify employer
            if ($job->employer) {
                $expiresText = $expiresAt ? $expiresAt->format('F j, Y') : null;
                $job->employer->notify(new \App\Notifications\JobPublished(
                    $job->id,
                    $job->title,
                    $expiresText
                ));
            }

            // Notify matching jobseekers
            $this->notifyMatchingJobseekers($job);

            return redirect()->back()->with('success', 'Featured ad request approved as Recommended job. Job is now published in Recommended section.');
        }

        // Original featured approval logic
        $expiresAt = null;
        $featuredExpiresAt = null;
        $featuredDuration = null;

        if ($wasFeaturedPending || $adType === 'featured' || in_array($priority, ['featured', 'premium', 'premium_15', 'premium_30'], true)) {
            $featuredDuration = (int) ($job->featured_duration ?? (
                $priority === 'premium_30' ? 30 :
                ($priority === 'premium_15' ? 15 :
                ($priority === 'premium' ? 7 : 7))
            ));

            if ($featuredDuration <= 0) {
                $featuredDuration = 7;
            }

            $featuredExpiresAt = now()->addDays($featuredDuration);

            // Featured ads should remain live at least as long as featured duration
            $expiresAt = now()->addDays(match($priority) {
                'premium' => 60,
                'premium_15' => 75,
                'premium_30' => 90,
                default => $featuredDuration,
            });
        } else {
            // Recommended / normal ads default to 7-day visibility
            $expiresAt = now()->addDays(7);
        }

        // Ensure recommended ads do not retain featured flags
        if (($adType === 'recommended' || $priority === 'normal') && !$wasFeaturedPending) {
            $featuredExpiresAt = null;
        }

        $job->update([
            'status' => 'published',
            'published_at' => now(),
            'expires_at' => $expiresAt,
            'featured_expires_at' => $featuredExpiresAt,
            'is_premium' => in_array($job->priority, ['premium', 'premium_15', 'premium_30']),
            'premium_expires_at' => in_array($job->priority, ['premium', 'premium_15', 'premium_30']) ? $expiresAt : null
        ]);

        // Notify employer that the job has been published
        if ($job->employer) {
            $expiresText = $expiresAt ? $expiresAt->format('F j, Y') : null;
            $job->employer->notify(new \App\Notifications\JobPublished(
                $job->id,
                $job->title,
                $expiresText
            ));
        }

        // Notify matching jobseekers about the new job
        $this->notifyMatchingJobseekers($job);

        $successMessage = 'Job approved and published successfully.';

        if ($wasFeaturedPending || $adType === 'featured') {
            $length = $featuredDuration ?? 7;
            $successMessage = "Featured ad approved and published successfully. Job will stay featured for {$length} day(s) and then continue as recommended.";
        } elseif (in_array($priority, ['premium', 'premium_15', 'premium_30'], true)) {
            $successMessage = 'Premium job approved and published successfully. Featured placement is active and job seekers have been notified.';
        } else {
            $successMessage = 'Recommended job approved and published successfully and is now visible in the Recommended section.';
        }

        $successMessage .= ' Matching jobseekers have been notified.';
        
        return redirect()->back()->with('success', $successMessage);
    }

    private function notifyMatchingJobseekers(JobPosting $job)
    {
        // Get all jobseekers with profiles
        $jobseekers = \App\Models\User::whereHas('role', function($q) {
            $q->where('slug', 'seeker');
        })->with('seekerProfile')->get();

        $companyName = $job->employer->employerProfile->company_name ?? 'Company';
        $location = $job->location_city . ', ' . $job->location_country;
        
        // Prepare salary range
        $salaryRange = null;
        if ($job->salary_min || $job->salary_max) {
            if ($job->salary_min && $job->salary_max) {
                $salaryRange = '$' . number_format($job->salary_min) . ' - $' . number_format($job->salary_max);
            } elseif ($job->salary_min) {
                $salaryRange = 'From $' . number_format($job->salary_min);
            } else {
                $salaryRange = 'Up to $' . number_format($job->salary_max);
            }
        }

        foreach ($jobseekers as $jobseeker) {
            if (!$jobseeker->seekerProfile) {
                continue;
            }

            $matchingReasons = $this->getMatchingReasons($job, $jobseeker->seekerProfile);
            
            // Only notify if there are matching reasons
            if (!empty($matchingReasons)) {
                $jobseeker->notify(new \App\Notifications\NewJobMatchingProfile(
                    $job->id,
                    $job->title,
                    $companyName,
                    $location,
                    $salaryRange,
                    $job->employment_type,
                    $job->experience_level,
                    $matchingReasons
                ));
            }
        }
    }

    private function getMatchingReasons(JobPosting $job, $seekerProfile): array
    {
        $reasons = [];

        // Check skills match
        if ($job->skills_required && $seekerProfile->skills) {
            $jobSkills = is_array($job->skills_required) ? $job->skills_required : json_decode($job->skills_required, true);
            $seekerSkills = is_array($seekerProfile->skills) ? $seekerProfile->skills : json_decode($seekerProfile->skills, true);
            
            if ($jobSkills && $seekerSkills) {
                $matchingSkills = array_intersect(
                    array_map('strtolower', $jobSkills),
                    array_map('strtolower', $seekerSkills)
                );
                
                if (!empty($matchingSkills)) {
                    $reasons[] = 'Skills match: ' . implode(', ', array_slice($matchingSkills, 0, 3));
                }
            }
        }

        // Check experience level match
        if ($job->experience_level && $seekerProfile->experience_years) {
            $jobExp = strtolower($job->experience_level);
            $seekerExp = strtolower($seekerProfile->experience_years);
            
            // Simple matching logic - can be enhanced
            if (($jobExp === 'entry' && str_contains($seekerExp, '1-2')) ||
                ($jobExp === 'mid' && (str_contains($seekerExp, '3-5') || str_contains($seekerExp, '2-3'))) ||
                ($jobExp === 'senior' && (str_contains($seekerExp, '5-7') || str_contains($seekerExp, '6-8'))) ||
                ($jobExp === 'executive' && str_contains($seekerExp, '7-10'))) {
                $reasons[] = 'Experience level matches your profile';
            }
        }

        // Check location match
        if ($job->location_city && $seekerProfile->city) {
            if (strtolower($job->location_city) === strtolower($seekerProfile->city)) {
                $reasons[] = 'Same city location';
            }
        }

        // Check current position match with job title
        if ($job->title && $seekerProfile->current_position) {
            $jobTitleWords = explode(' ', strtolower($job->title));
            $positionWords = explode(' ', strtolower($seekerProfile->current_position));
            
            $commonWords = array_intersect($jobTitleWords, $positionWords);
            if (count($commonWords) >= 1) {
                $reasons[] = 'Job title matches your current position';
            }
        }

        return $reasons;
    }

    public function reject(JobPosting $job)
    {
        $job->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Job rejected successfully.');
    }

    /**
     * Toggle featured status for a published job
     */
    public function toggleFeatured(Request $request, JobPosting $job)
    {
        if ($job->status !== 'published') {
            return redirect()->back()->with('error', 'Only published jobs can be featured/unfeatured.');
        }

        $makeFeatured = $request->has('make_featured') && $request->make_featured == '1';
        
        if ($makeFeatured) {
            // Make job featured
            $duration = (int) ($request->featured_duration ?? 7);
            if ($duration <= 0) {
                $duration = 7;
            }

            $featuredExpiresAt = now()->addDays($duration);
            $expiresAt = now()->addDays(max($duration, 7));

            $job->update([
                'ad_type' => 'featured',
                'priority' => 'featured',
                'featured_expires_at' => $featuredExpiresAt,
                'featured_duration' => $duration,
                'expires_at' => $expiresAt,
                'is_premium' => false,
            ]);

            return redirect()->back()->with('success', "Job featured successfully for {$duration} days.");
        } else {
            // Convert featured to regular/recommended
            $job->update([
                'ad_type' => 'recommended',
                'priority' => 'normal',
                'featured_expires_at' => null,
                'featured_duration' => null,
                'is_premium' => false,
                'premium_expires_at' => null,
            ]);

            return redirect()->back()->with('success', 'Job converted to regular/recommended successfully.');
        }
    }

    public function destroy(JobPosting $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}