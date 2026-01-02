<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\EmployerDocument;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $verifiedUsers = User::whereNotNull('email_verified_at');

        $stats = [
            'total_users' => (clone $verifiedUsers)->count(),
            'total_seekers' => (clone $verifiedUsers)->whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })->count(),
            'total_employers' => (clone $verifiedUsers)->whereHas('role', function($q) {
                $q->where('slug', 'employer');
            })->count(),
            'total_jobs' => JobPosting::count(),
            'published_jobs' => JobPosting::where('status', 'published')->count(),
            'pending_jobs' => JobPosting::where('status', 'draft')->orWhere('status', 'pending')->count(),
            'total_applications' => JobApplication::count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'pending_users' => (clone $verifiedUsers)->whereHas('role', function($q) {
                    // Exclude admins
                    $q->where('slug', '!=', 'admin');
                })
                ->where(function($q) {
                    // Show users who are inactive OR not approved OR have pending profile approval
                    $q->where('status', 'inactive')
                      ->orWhere('is_approved', false)
                      ->orWhereHas('seekerProfile', function($sq) {
                          $sq->where('approval_status', 'pending');
                      })
                      ->orWhereHas('employerProfile', function($eq) {
                          $eq->where('approval_status', 'pending');
                      });
                })
                // Exclude fully approved users: active + approved + profile approved
                ->where(function($q) {
                    $q->where('status', '!=', 'active')
                      ->orWhere('is_approved', false)
                      ->orWhere(function($subQ) {
                          $subQ->whereHas('seekerProfile', function($sq) {
                              $sq->where('approval_status', '!=', 'approved');
                          })
                          ->orWhereHas('employerProfile', function($eq) {
                              $eq->where('approval_status', '!=', 'approved');
                          })
                          ->orWhereDoesntHave('seekerProfile')
                          ->orWhereDoesntHave('employerProfile');
                      });
                })
                ->count(),
            'pending_documents' => EmployerDocument::where('status', 'pending')->count(),
        ];

        $recent_users = (clone $verifiedUsers)->with('role')->latest()->take(5)->get();
        $recent_jobs = JobPosting::with('employer')->latest()->take(5)->get();
        $recent_applications = JobApplication::with(['job', 'seeker'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_jobs', 'recent_applications'));
    }
}



