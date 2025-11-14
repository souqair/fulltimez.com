<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCVRequest;
use App\Models\Certificate;
use App\Models\EducationRecord;
use App\Models\ExperienceRecord;
use App\Models\Project;
use App\Models\Role;
use App\Notifications\ResumeNeedsReapproval;
use App\Notifications\UserActionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CVController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        
        // Load existing CV data
        $profile = $user->seekerProfile;
        $projects = $user->projects()->get();
        $experiences = $user->experienceRecords()->get();
        $educations = $user->educationRecords()->get();
        $certificates = $user->certificates()->get();
        
        return view('seeker.create-cv', compact('profile', 'projects', 'experiences', 'educations', 'certificates'));
    }

    public function saveStep(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isSeeker()) {
            abort(403);
        }

        $step = $request->input('step');
        $validSteps = ['basic', 'bio', 'projects', 'experience', 'education', 'certificates', 'skills'];

        if (!in_array($step, $validSteps, true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid step provided.',
            ], 422);
        }

        $profile = $this->ensureSeekerProfile($user);

        switch ($step) {
            case 'basic':
                $validator = Validator::make($request->all(), [
                    'current_position' => 'required|string|max:255',
                    'expected_salary' => 'nullable|string|max:100',
                    'experience_years' => 'required|string|max:50',
                    'nationality' => 'required|string|max:100',
                    'first_language' => 'required|string|max:50',
                    'second_language' => 'nullable|string|max:50',
                    'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                    'cropped_image_data' => 'nullable|string',
                ], [
                    'current_position.required' => 'Current role is required.',
                    'experience_years.required' => 'Years of experience is required.',
                    'nationality.required' => 'Nationality is required.',
                    'first_language.required' => 'First language is required.',
                    'profile_picture.image' => 'Profile picture must be an image.',
                    'profile_picture.max' => 'Profile picture must be less than 2MB.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $data = $validator->validated();

                $profile->current_position = $data['current_position'];
                $profile->expected_salary = $data['expected_salary'] ?? null;
                $profile->experience_years = $data['experience_years'];
                $profile->nationality = $data['nationality'];

                $languages = array_values(array_filter([
                    $data['first_language'] ?? null,
                    $data['second_language'] ?? null,
                ], fn ($value) => !empty($value)));
                $profile->languages = $languages;

                if ($request->hasFile('profile_picture')) {
                    $this->replaceProfileImage($profile, $request->file('profile_picture'), $user);
                } elseif (!empty($data['cropped_image_data'])) {
                    $this->replaceProfileImage($profile, null, $user, $data['cropped_image_data']);
                }

                $profile->save();
                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Basic information saved successfully.',
                    'step' => $step,
                ]);

            case 'bio':
                $validator = Validator::make($request->all(), [
                    'bio' => 'required|string|min:100|max:2000',
                    'linkedin' => 'nullable|url|max:255',
                    'github' => 'nullable|url|max:255',
                    'twitter' => 'nullable|url|max:255',
                    'website' => 'nullable|url|max:255',
                    'facebook' => 'nullable|url|max:255',
                    'instagram' => 'nullable|url|max:255',
                ], [
                    'bio.required' => 'Bio is required.',
                    'bio.min' => 'Bio must be at least 100 characters.',
                    'bio.max' => 'Bio must not exceed 2000 characters.',
                    'linkedin.url' => 'LinkedIn link must be a valid URL.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $data = $validator->validated();
                $profile->bio = $data['bio'];

                $socialLinks = array_filter([
                    'linkedin' => $data['linkedin'] ?? null,
                    'github' => $data['github'] ?? null,
                    'twitter' => $data['twitter'] ?? null,
                    'website' => $data['website'] ?? null,
                    'facebook' => $data['facebook'] ?? null,
                    'instagram' => $data['instagram'] ?? null,
                ], fn ($value) => !empty($value));

                if (Schema::hasColumn('seeker_profiles', 'social_links')) {
                    $profile->social_links = !empty($socialLinks) ? json_encode($socialLinks) : null;
                }

                foreach ($socialLinks as $key => $value) {
                    if (Schema::hasColumn('seeker_profiles', $key)) {
                        $profile->{$key} = $value;
                    }
                }

                $profile->save();
                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Bio details saved successfully.',
                    'step' => $step,
                ]);

            case 'projects':
                $validator = Validator::make($request->all(), [
                    'projects' => 'nullable|array',
                    'projects.*.name' => 'nullable|string|max:255',
                    'projects.*.type' => 'nullable|string|max:100',
                    'projects.*.link' => 'nullable|url|max:255',
                    'projects.*.description' => 'nullable|string|max:1000',
                ], [
                    'projects.*.link.url' => 'Project link must be a valid URL.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $projects = $this->sanitizeArrayInput($request->input('projects', []));

                Project::where('seeker_id', $user->id)->delete();

                foreach ($projects as $project) {
                    Project::create([
                        'seeker_id' => $user->id,
                        'project_name' => $project['name'] ?? null,
                        'project_type' => $project['type'] ?? null,
                        'project_link' => $project['link'] ?? null,
                        'description' => $project['description'] ?? null,
                    ]);
                }

                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Projects saved successfully.',
                    'step' => $step,
                ]);

            case 'experience':
                $validator = Validator::make($request->all(), [
                    'experience' => 'nullable|array',
                    'experience.*.company' => 'nullable|string|max:255',
                    'experience.*.title' => 'nullable|string|max:255',
                    'experience.*.start_date' => 'nullable|date',
                    'experience.*.end_date' => 'nullable|date',
                    'experience.*.description' => 'nullable|string|max:1000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $experiences = $this->sanitizeArrayInput($request->input('experience', []));

                ExperienceRecord::where('seeker_id', $user->id)->delete();

                foreach ($experiences as $experience) {
                    ExperienceRecord::create([
                        'seeker_id' => $user->id,
                        'company_name' => $experience['company'] ?? null,
                        'job_title' => $experience['title'] ?? null,
                        'start_date' => $experience['start_date'] ?? null,
                        'end_date' => $experience['end_date'] ?? null,
                        'is_current' => empty($experience['end_date']),
                        'description' => $experience['description'] ?? null,
                    ]);
                }

                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Experience saved successfully.',
                    'step' => $step,
                ]);

            case 'education':
                $validator = Validator::make($request->all(), [
                    'education' => 'nullable|array',
                    'education.*.institution' => 'nullable|string|max:255',
                    'education.*.degree' => 'nullable|string|max:255',
                    'education.*.field' => 'nullable|string|max:255',
                    'education.*.year' => 'nullable|integer|min:1950|max:' . (date('Y') + 10),
                    'education.*.start_date' => 'nullable|date',
                    'education.*.end_date' => 'nullable|date',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $educations = $this->sanitizeArrayInput($request->input('education', []));

                EducationRecord::where('seeker_id', $user->id)->delete();

                foreach ($educations as $education) {
                    $startDate = !empty($education['start_date']) ? \Carbon\Carbon::parse($education['start_date']) : null;
                    $endDate = !empty($education['end_date']) ? \Carbon\Carbon::parse($education['end_date']) : null;

                    if (!$endDate && !empty($education['year'])) {
                        $endDate = \Carbon\Carbon::create((int) $education['year'], 6, 1);
                    }

                    if (!$startDate && $endDate) {
                        $startDate = $endDate->copy()->subYears(4);
                    }

                    EducationRecord::create([
                        'seeker_id' => $user->id,
                        'institution_name' => $education['institution'] ?? null,
                        'degree' => $education['degree'] ?? null,
                        'field_of_study' => $education['field'] ?? null,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]);
                }

                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Education saved successfully.',
                    'step' => $step,
                ]);

            case 'certificates':
                $validator = Validator::make($request->all(), [
                    'certificates' => 'nullable|array',
                    'certificates.*.name' => 'nullable|string|max:255',
                    'certificates.*.organization' => 'nullable|string|max:255',
                    'certificates.*.date' => 'nullable|date',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $certificates = $this->sanitizeArrayInput($request->input('certificates', []));

                Certificate::where('seeker_id', $user->id)->delete();

                foreach ($certificates as $certificate) {
                    Certificate::create([
                        'seeker_id' => $user->id,
                        'certificate_name' => $certificate['name'] ?? null,
                        'issuing_organization' => $certificate['organization'] ?? null,
                        'issue_date' => $certificate['date'] ?? null,
                        'does_not_expire' => true,
                    ]);
                }

                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Certificates saved successfully.',
                    'step' => $step,
                ]);

            case 'skills':
                $validator = Validator::make($request->all(), [
                    'skills' => 'required|string',
                ], [
                    'skills.required' => 'Please add at least one skill.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'validation_error',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $skills = array_values(array_filter(array_map('trim', explode(',', $request->input('skills'))), fn ($value) => !empty($value)));

                $profile->skills = $skills;
                $profile->save();

                $this->markResumePending($user);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Skills saved successfully.',
                    'step' => $step,
                ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unable to process the requested step.',
        ], 422);
    }

    public function submit(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isSeeker()) {
            abort(403);
        }

        $profile = $user->seekerProfile;

        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please complete your CV details before submitting.',
            ], 422);
        }

        $missing = [];
        $requiredFields = [
            'current_position' => 'Current role',
            'experience_years' => 'Years of experience',
            'nationality' => 'Nationality',
            'languages' => 'Languages',
            'bio' => 'Professional bio',
            'skills' => 'Skills',
        ];

        foreach ($requiredFields as $field => $label) {
            $value = $profile->{$field};
            if ($field === 'languages' || $field === 'skills') {
                if (empty($value) || count((array) $value) === 0) {
                    $missing[] = $label;
                }
                continue;
            }

            if (empty($value)) {
                $missing[] = $label;
            }
        }

        if (!empty($missing)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please complete the following sections before submitting: ' . implode(', ', $missing) . '.',
            ], 422);
        }

        $this->markResumePending($user);

        $user->notify(new UserActionNotification(
            'cv_updated',
            'updated your CV',
            'Your CV changes have been submitted for review. Once approved, you will be able to download the updated PDF.',
            route('resume.preview'),
            'View CV'
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'Your CV has been submitted for approval. You will be notified once it is reviewed.',
            'redirect' => route('resume.preview'),
        ]);
    }

    public function store(StoreCVRequest $request)
    {
        $user = auth()->user();
        $wasApproved = false; // Track if CV was previously approved

        if ($user->seekerProfile) {
            // Check if CV was previously approved before updating
            $wasApproved = $user->seekerProfile->approval_status === 'approved';
            
            // Update basic profile data
            $profileData = [
                'current_position' => $request->current_position,
                'expected_salary' => $request->expected_salary,
                'experience_years' => $request->experience_years,
                'nationality' => $request->nationality,
                'bio' => $request->bio,
            ];

            // Social links (optional)
            $links = [
                'linkedin' => $request->input('linkedin'),
                'github' => $request->input('github'),
                'twitter' => $request->input('twitter'),
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
                'instagram' => $request->input('instagram'),
            ];
            // Save JSON if column exists
            $nonEmptyLinks = array_filter($links, function ($v) { return !empty($v); });
            if (!empty($nonEmptyLinks) && Schema::hasColumn('seeker_profiles', 'social_links')) {
                $profileData['social_links'] = json_encode($nonEmptyLinks);
            }
            // Also save individual columns if they exist
            foreach ($links as $key => $value) {
                if (Schema::hasColumn('seeker_profiles', $key)) {
                    $profileData[$key] = $value;
                }
            }

            // Handle profile picture upload (optional)
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                if ($file->isValid()) {
                    $directory = public_path('images/profiles');
                    if (!is_dir($directory)) {
                        mkdir($directory, 0755, true);
                    }
                    $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move($directory, $filename);
                    $profileData['profile_picture'] = 'images/profiles/' . $filename;
                }
            }

            // Handle languages - Always save (even if empty)
            $languages = [];
            if ($request->filled('first_language')) {
                $languages[] = $request->first_language;
            }
            if ($request->filled('second_language')) {
                $languages[] = $request->second_language;
            }
            // Save languages array (empty array if no languages selected)
            $profileData['languages'] = !empty($languages) ? json_encode($languages) : json_encode([]);

            // Handle skills - convert comma-separated string to JSON array
            if ($request->skills) {
                $skillsArray = array_map('trim', explode(',', $request->skills));
                $skillsArray = array_filter($skillsArray);
                $profileData['skills'] = json_encode(array_values($skillsArray));
            }

            // Set approval_status to pending when CV is updated (mandatory re-approval)
            $profileData['approval_status'] = 'pending';
            
            $user->seekerProfile()->update($profileData);
            
            // Notify all admins if CV was previously approved and now needs re-approval
            if ($wasApproved) {
                $adminRole = \App\Models\Role::where('slug', 'admin')->first();
                if ($adminRole) {
                    $admins = \App\Models\User::where('role_id', $adminRole->id)->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new \App\Notifications\ResumeNeedsReapproval(
                            $user->id,
                            $user->seekerProfile->full_name ?? $user->name
                        ));
                    }
                }
            }
        }

        // Handle multiple projects (Update/Insert)
        if ($request->has('projects')) {
            Project::where('seeker_id', $user->id)->delete();
            foreach ($request->projects as $projectData) {
                if (!empty($projectData['name'])) {
                    Project::create([
                        'seeker_id' => $user->id,
                        'project_name' => $projectData['name'],
                        'project_type' => $projectData['type'] ?? null,
                        'project_link' => $projectData['link'] ?? null,
                        'description' => $projectData['description'] ?? null,
                    ]);
                }
            }
        }

        // Handle multiple experience records
        if ($request->has('experience')) {
            ExperienceRecord::where('seeker_id', $user->id)->delete();
            foreach ($request->experience as $expData) {
                if (!empty($expData['company']) && !empty($expData['title'])) {
                    ExperienceRecord::create([
                        'seeker_id' => $user->id,
                        'company_name' => $expData['company'],
                        'job_title' => $expData['title'],
                        'start_date' => $expData['start_date'] ?? null,
                        'end_date' => $expData['end_date'] ?? null,
                        'is_current' => empty($expData['end_date']),
                        'description' => $expData['description'] ?? null,
                    ]);
                }
            }
        }

        // Handle multiple education records
        if ($request->has('education')) {
            EducationRecord::where('seeker_id', $user->id)->delete();
            foreach ($request->education as $eduData) {
                if (!empty($eduData['institution']) && !empty($eduData['degree'])) {
                    $startDate = !empty($eduData['start_date']) ? \Carbon\Carbon::parse($eduData['start_date']) : null;
                    $endDate = !empty($eduData['end_date']) ? \Carbon\Carbon::parse($eduData['end_date']) : null;
                    if (!$endDate && !empty($eduData['year'])) {
                        $endDate = \Carbon\Carbon::create((int)$eduData['year'], 6, 1);
                    }
                    if (!$startDate && $endDate) {
                        $startDate = $endDate->copy()->subYears(4);
                    }
                    EducationRecord::create([
                        'seeker_id' => $user->id,
                        'institution_name' => $eduData['institution'],
                        'degree' => $eduData['degree'],
                        'field_of_study' => $eduData['field'] ?? null,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]);
                }
            }
        }

        // Handle multiple certificates
        if ($request->has('certificates')) {
            Certificate::where('seeker_id', $user->id)->delete();
            foreach ($request->certificates as $certData) {
                if (!empty($certData['name']) && !empty($certData['organization'])) {
                    Certificate::create([
                        'seeker_id' => $user->id,
                        'certificate_name' => $certData['name'],
                        'issuing_organization' => $certData['organization'],
                        'issue_date' => $certData['date'] ?? now(),
                        'does_not_expire' => true,
                    ]);
                }
            }
        }

        $user->notify(new UserActionNotification(
            'cv_updated',
            'updated your CV',
            'Your CV has been updated successfully. All your information including projects, experience, education, and certificates have been saved. Your CV is now pending admin approval and will be reviewed shortly.',
            route('seeker.cv.create'),
            'View CV'
        ));

        $approvalMessage = $wasApproved 
            ? 'CV saved successfully! Your CV has been updated and requires re-approval from admin. It will be reviewed shortly.'
            : 'CV saved successfully! All your information has been updated.';

        return redirect()->route('seeker.cv.create')->with('success', $approvalMessage);
    }

    protected function ensureSeekerProfile($user)
    {
        $profile = $user->seekerProfile;

        if ($profile) {
            return $profile;
        }

        return $user->seekerProfile()->create([
            'user_id' => $user->id,
            'approval_status' => 'pending',
            'verification_status' => 'pending',
        ]);
    }

    protected function replaceProfileImage($profile, $file, $user, ?string $base64 = null): void
    {
        if (!$file && empty($base64)) {
            return;
        }

        $this->deleteProfileImage($profile->profile_picture);

        if ($file) {
            $directory = public_path('images/profiles');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'profile_' . $user->id . '_' . time() . '_' . Str::random(6) . '.' . $extension;
            $file->move($directory, $filename);
            $profile->profile_picture = 'images/profiles/' . $filename;

            return;
        }

        $path = $this->storeImageFromBase64($base64, $user);
        if ($path) {
            $profile->profile_picture = $path;
        }
    }

    protected function deleteProfileImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    protected function storeImageFromBase64(?string $base64, $user): ?string
    {
        if (empty($base64)) {
            return null;
        }

        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
            return null;
        }

        $type = strtolower($matches[1]);
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (!in_array($type, $allowedTypes, true)) {
            $type = 'jpg';
        }

        $base64 = substr($base64, strpos($base64, ',') + 1);
        $imageData = base64_decode($base64);

        if ($imageData === false) {
            return null;
        }

        $directory = public_path('images/profiles');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = $type === 'jpeg' ? 'jpg' : $type;
        $filename = 'profile_' . $user->id . '_' . time() . '_' . Str::random(6) . '.' . $extension;
        $fullPath = $directory . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($fullPath, $imageData);

        return 'images/profiles/' . $filename;
    }

    protected function markResumePending($user): void
    {
        $profile = $this->ensureSeekerProfile($user);
        $shouldNotifyAdmins = $profile->approval_status === 'approved';

        if ($profile->approval_status !== 'pending') {
            $profile->approval_status = 'pending';
        }

        if (empty($profile->verification_status)) {
            $profile->verification_status = 'pending';
        }

        $profile->save();

        if ($shouldNotifyAdmins && $profile->approval_status === 'pending') {
            $this->notifyAdminsForReapproval($user);
        }
    }

    protected function notifyAdminsForReapproval($user): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        if (!$adminRole) {
            return;
        }

        $admins = \App\Models\User::where('role_id', $adminRole->id)->get();

        foreach ($admins as $admin) {
            $admin->notify(new ResumeNeedsReapproval(
                $user->id,
                $user->seekerProfile->full_name ?? $user->name
            ));
        }
    }

    protected function sanitizeArrayInput($items): array
    {
        if (!is_array($items)) {
            return [];
        }

        $sanitized = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $hasValue = false;

            foreach ($item as $value) {
                if (is_string($value)) {
                    $value = trim($value);
                }

                if ($value !== null && $value !== '') {
                    $hasValue = true;
                    break;
                }
            }

            if ($hasValue) {
                $sanitized[] = $item;
            }
        }

        return $sanitized;
    }
}
