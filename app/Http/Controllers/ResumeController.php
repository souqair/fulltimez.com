<?php

namespace App\Http\Controllers;

use App\Notifications\UserActionNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\JobApplication;

class ResumeController extends Controller
{
    public function preview()
    {
        $user = auth()->user();
        
        if (!$user->isSeeker()) {
            return redirect()->route('dashboard')->with('error', 'Only job seekers can view resume.');
        }
        
        $profile = $user->seekerProfile;

        if (!$profile) {
            return redirect()->route('resume.preview')
                ->with('error', 'Please complete your CV before downloading the resume.');
        }

        if ($profile->approval_status !== 'approved') {
            $statusMessage = $profile->approval_status === 'pending'
                ? 'Your CV is pending admin approval. You will be able to download it once it has been approved.'
                : 'Your CV is not approved yet. Please contact support if you believe this is a mistake.';

            return redirect()->route('resume.preview')->with('error', $statusMessage);
        }

        $projects = $user->projects()->get();
        $experiences = $user->experienceRecords()->orderBy('start_date', 'desc')->get();
        $educations = $user->educationRecords()->orderBy('end_date', 'desc')->get();
        $certificates = $user->certificates()->orderBy('issue_date', 'desc')->get();
        
        // If ?template=cv is requested, render the HTML template style with user data
        if (request()->get('template') === 'cv') {
            // Seekers can see their own contact details
            $showContactDetails = true;
            return view('seeker.cv-index', compact('user', 'profile', 'projects', 'experiences', 'educations', 'certificates', 'showContactDetails'));
        }
        
        return view('seeker.resume-preview', compact('user', 'profile', 'projects', 'experiences', 'educations', 'certificates'));
    }

    // classic preview route removed

    public function download()
    {
        $user = auth()->user();
        
        if (!$user->isSeeker()) {
            abort(403, 'Unauthorized');
        }
        
        $profile = $user->seekerProfile;
        if (!$profile) {
            return redirect()->route('resume.preview')
                ->with('error', 'Please complete your CV before downloading the resume.');
        }

        if ($profile->approval_status !== 'approved') {
            $statusMessage = $profile->approval_status === 'pending'
                ? 'Your CV is pending admin approval. You will be able to download it once it has been approved.'
                : 'Your CV is not approved yet. Please contact support if you believe this is a mistake.';

            return redirect()->route('resume.preview')->with('error', $statusMessage);
        }

        $projects = $user->projects()->get();
        $experiences = $user->experienceRecords()->orderBy('start_date', 'desc')->get();
        $educations = $user->educationRecords()->orderBy('end_date', 'desc')->get();
        $certificates = $user->certificates()->orderBy('issue_date', 'desc')->get();
        
        $pdf = Pdf::loadView('seeker.resume-pdf', compact('user', 'profile', 'projects', 'experiences', 'educations', 'certificates'));
        
        $filename = str_replace(' ', '_', $profile->full_name ?? $user->name) . '_Resume.pdf';
        
        // Send notification about resume download
        $user->notify(new UserActionNotification(
            'resume_downloaded',
            'downloaded your resume',
            'Your resume has been downloaded successfully. Keep it safe and use it for your job applications.',
            route('resume.preview'),
            'View Resume'
        ));
        
        return $pdf->download($filename);
    }

    public function showForReview(User $user)
    {
        // Only admins or employers can review other users' resumes
        $viewer = auth()->user();
        if (!$viewer || !($viewer->isAdmin() || $viewer->isEmployer())) {
            abort(403, 'Unauthorized');
        }

        // Ensure the target is a seeker
        if (!$user->isSeeker()) {
            abort(404);
        }

        $profile = $user->seekerProfile;
        $projects = $user->projects()->get();
        $experiences = $user->experienceRecords()->orderBy('start_date', 'desc')->get();
        $educations = $user->educationRecords()->orderBy('end_date', 'desc')->get();
        $certificates = $user->certificates()->orderBy('issue_date', 'desc')->get();

        $showContactDetails = false;
        if ($viewer->isAdmin()) {
            $showContactDetails = true;
        } elseif ($viewer->isEmployer()) {
            $showContactDetails = JobApplication::where('seeker_id', $user->id)
                ->whereHas('job', function($q) use ($viewer) {
                    $q->where('employer_id', $viewer->id);
                })
                ->exists();
        }

        // Render the HTML template version for review
        return view('seeker.cv-index', compact('user', 'profile', 'projects', 'experiences', 'educations', 'certificates', 'showContactDetails'));
    }
}



