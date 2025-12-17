<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ResumeApproved;
use App\Notifications\ResumeNeedsReapproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'seekerProfile', 'employerProfile']);

        if ($request->has('role') && $request->role != '') {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'pending') {
                // Show only pending/inactive users
                // Exclude admins and fully approved users
                $query->whereHas('role', function($q) {
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
                          // Profile not approved or doesn't exist
                          $subQ->whereHas('seekerProfile', function($sq) {
                              $sq->where('approval_status', '!=', 'approved');
                          })
                          ->orWhereHas('employerProfile', function($eq) {
                              $eq->where('approval_status', '!=', 'approved');
                          })
                          ->orWhereDoesntHave('seekerProfile')
                          ->orWhereDoesntHave('employerProfile');
                      });
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->get('per_page', 24);
        $perPage = in_array($perPage, [12, 24, 48]) ? $perPage : 24;
        
        $users = $query->latest()->paginate($perPage);

        // Calculate statistics
        $stats = [
            'total' => User::count(),
            'seekers' => User::whereHas('role', function($q) { $q->where('slug', 'seeker'); })->count(),
            'employers' => User::whereHas('role', function($q) { $q->where('slug', 'employer'); })->count(),
            'admins' => User::whereHas('role', function($q) { $q->where('slug', 'admin'); })->count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'banned' => User::where('status', 'banned')->count(),
            'approved' => User::where('is_approved', true)->count(),
            'pending_approval' => User::where('is_approved', false)->whereHas('role', function($q) {
                $q->whereIn('slug', ['seeker', 'employer']);
            })->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        $user->load(['role', 'employerProfile', 'seekerProfile']);
        return view('admin.users.show', compact('user'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,banned'
        ]);

        $user->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'User status updated successfully!');
    }

    public function approveEmployer(User $user)
    {
        if (!$user->isEmployer() || !$user->employerProfile) {
            return redirect()->back()->with('error', 'Employer profile not found for this user.');
        }

        $user->employerProfile->update(['verification_status' => 'verified']);
        $user->update(['is_approved' => true]);

        // Send approval email notification
        try {
            $user->notify(new \App\Notifications\AccountApproved('employer'));
        } catch (\Exception $e) {
            // Log error but continue with approval
            \Log::error('Failed to send approval email to employer: ' . $e->getMessage());
        }

        // Remove related "new employer pending approval" notifications for all admins
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            User::where('role_id', $adminRole->id)->get()->each(function($admin) use ($user) {
                $admin->notifications()->where('data->employer_user_id', $user->id)->delete();
            });
        }

        return redirect()->back()->with('success', 'Employer account approved successfully. Approval email has been sent.');
    }

    public function rejectEmployer(User $user)
    {
        if (!$user->isEmployer() || !$user->employerProfile) {
            return redirect()->back()->with('error', 'Employer profile not found for this user.');
        }

        $user->employerProfile->update(['verification_status' => 'rejected']);
        $user->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Employer account rejected successfully.');
    }

    public function approveSeeker(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $profile = $user->seekerProfile;
        $wasAlreadyApproved = $profile->approval_status === 'approved';

        $profile->update([
            'verification_status' => 'verified',
            'approval_status' => 'approved' // Resume approval
        ]);
        $user->update(['is_approved' => true]); // Account approval

        if (!$wasAlreadyApproved) {
            $user->notify(new ResumeApproved());
            $this->clearResumeReapprovalNotifications($user);
        }

        // Send approval email notification
        try {
            $user->notify(new \App\Notifications\AccountApproved('seeker'));
        } catch (\Exception $e) {
            // Log error but continue with approval
            \Log::error('Failed to send approval email to seeker: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Jobseeker account and resume approved successfully. Approval email has been sent.');
    }

    public function rejectSeeker(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $user->seekerProfile->update([
            'verification_status' => 'rejected',
            'approval_status' => 'rejected'
        ]);
        $user->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Jobseeker account rejected successfully.');
    }

    /**
     * Approve a seeker resume (for Browse Resume page)
     */
    public function approveResume(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $profile = $user->seekerProfile;
        $wasAlreadyApproved = $profile->approval_status === 'approved';

        $profile->update(['approval_status' => 'approved']);

        if (!$wasAlreadyApproved) {
            $user->notify(new ResumeApproved());
            $this->clearResumeReapprovalNotifications($user);
        }

        return redirect()->back()->with('success', 'Resume approved successfully. It will now appear on Browse Resume page.');
    }

    /**
     * Reject a seeker resume
     */
    public function rejectResume(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $user->seekerProfile->update(['approval_status' => 'rejected']);

        return redirect()->back()->with('success', 'Resume rejected successfully.');
    }

    /**
     * Bulk approve users
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->user_ids;
        $approvedCount = 0;
        $failedCount = 0;

        foreach ($userIds as $userId) {
            try {
                $user = User::findOrFail($userId);
                
                // Skip admins
                if ($user->isAdmin()) {
                    continue;
                }

                if ($user->isSeeker() && $user->seekerProfile) {
                    // Approve seeker
                    $profile = $user->seekerProfile;
                    $wasAlreadyApproved = $profile->approval_status === 'approved';

                    $profile->update([
                        'verification_status' => 'verified',
                        'approval_status' => 'approved'
                    ]);
                    $user->update(['is_approved' => true]);

                    if (!$wasAlreadyApproved) {
                        $user->notify(new ResumeApproved());
                    }

                    try {
                        $user->notify(new \App\Notifications\AccountApproved('seeker'));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send approval email to seeker: ' . $e->getMessage());
                    }
                } elseif ($user->isEmployer() && $user->employerProfile) {
                    // Approve employer
                    $user->employerProfile->update(['verification_status' => 'verified']);
                    $user->update(['is_approved' => true]);

                    try {
                        $user->notify(new \App\Notifications\AccountApproved('employer'));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send approval email to employer: ' . $e->getMessage());
                    }
                }

                $approvedCount++;
            } catch (\Exception $e) {
                $failedCount++;
                \Log::error('Failed to approve user ' . $userId . ': ' . $e->getMessage());
            }
        }

        $message = "Successfully approved {$approvedCount} user(s).";
        if ($failedCount > 0) {
            $message .= " {$failedCount} user(s) failed to approve.";
        }

        return redirect()->back()->with('success', $message);
    }

    protected function clearResumeReapprovalNotifications(User $user): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        if (!$adminRole) {
            return;
        }

        User::where('role_id', $adminRole->id)->each(function ($admin) use ($user) {
            $admin->notifications()
                ->where('type', ResumeNeedsReapproval::class)
                ->where('data->seeker_user_id', $user->id)
                ->delete();
        });
    }

    /**
     * Feature a seeker resume (for homepage)
     */
    public function featureResume(Request $request, User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $approveAsRegular = $request->has('as_regular') && $request->as_regular == '1';
        
        // If admin wants to approve as regular (non-featured) instead of featured
        if ($approveAsRegular) {
            // First approve if not already approved
            if ($user->seekerProfile->approval_status !== 'approved') {
                $user->seekerProfile->update(['approval_status' => 'approved']);
                $user->notify(new ResumeApproved());
            }
            
            // Ensure it's not featured
            $user->seekerProfile->update([
                'is_featured' => false,
                'featured_expires_at' => null,
            ]);

            return redirect()->back()->with('success', 'Resume approved as regular (non-featured). It will appear on Browse Resume page but not on homepage.');
        }

        $request->validate([
            'featured_duration' => 'required|integer|min:1|max:365', // days
        ]);

        // First approve if not already approved (so it can be featured)
        if ($user->seekerProfile->approval_status !== 'approved') {
            $user->seekerProfile->update(['approval_status' => 'approved']);
            $user->notify(new ResumeApproved());
        }

        // Set featured - cast to int to ensure it's not a string
        $featuredExpiresAt = now()->addDays((int)$request->featured_duration);
        $user->seekerProfile->update([
            'is_featured' => true,
            'featured_expires_at' => $featuredExpiresAt,
        ]);

        return redirect()->back()->with('success', 'Resume featured successfully for ' . $request->featured_duration . ' days. It will appear on homepage.');
    }

    /**
     * Unfeature a seeker resume
     */
    public function unfeatureResume(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile) {
            return redirect()->back()->with('error', 'Seeker profile not found for this user.');
        }

        $user->seekerProfile->update([
            'is_featured' => false,
            'featured_expires_at' => null,
        ]);

        return redirect()->back()->with('success', 'Resume unfeatured successfully.');
    }

    /**
     * Admin: Download jobseeker CV
     */
    public function downloadCv(User $user)
    {
        if (!$user->isSeeker() || !$user->seekerProfile || !$user->seekerProfile->cv_file) {
            return redirect()->back()->with('error', 'CV not found for this user.');
        }

        $path = $user->seekerProfile->cv_file;
        $fullPath = public_path($path);
        
        if (!file_exists($fullPath)) {
            return redirect()->back()->with('error', 'CV file is missing on the server.');
        }

        return response()->download($fullPath, 'CV-'.$user->name.'.pdf');
    }

    /**
     * Admin: Show list of seekers with CVs for bulk download
     */
    public function resumesIndex(Request $request)
    {
        $query = User::whereHas('role', function($q) {
            $q->where('slug', 'seeker');
        })->whereHas('seekerProfile', function($q) {
            $q->whereNotNull('cv_file');
        })->with('seekerProfile');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('seekerProfile', function($sq) use ($search) {
                      $sq->where('current_position', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }

        $seekers = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin.users.resumes', compact('seekers'));
    }

    /**
     * Admin: Bulk download CVs
     */
    public function bulkDownloadCvs(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $request->user_ids)
            ->whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->with('seekerProfile')
            ->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No valid seekers selected.');
        }

        $zip = new \ZipArchive();
        $zipFileName = 'resumes_' . date('Y-m-d_His') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Create temp directory if it doesn't exist
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return redirect()->back()->with('error', 'Failed to create zip file.');
        }

        $addedCount = 0;
        foreach ($users as $user) {
            if ($user->seekerProfile && $user->seekerProfile->cv_file) {
                $filePath = public_path($user->seekerProfile->cv_file);
                if (file_exists($filePath)) {
                    $fileName = 'CV-' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $user->name) . '.pdf';
                    $zip->addFile($filePath, $fileName);
                    $addedCount++;
                }
            }
        }

        $zip->close();

        if ($addedCount === 0) {
            return redirect()->back()->with('error', 'No valid CV files found to download.');
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Cannot delete admin user!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /**
     * Admin: Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $users = User::whereIn('id', $request->user_ids)
            ->whereHas('role', function($q) {
                $q->where('slug', '!=', 'admin');
            })
            ->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No valid users selected for deletion.');
        }

        $deletedCount = 0;
        foreach ($users as $user) {
            if (!$user->isAdmin()) {
                $user->delete();
                $deletedCount++;
            }
        }

        return redirect()->back()->with('success', "{$deletedCount} user(s) deleted successfully!");
    }

    /**
     * Admin: Reset a user's password.
     */
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'notify' => 'nullable|boolean',
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        // Optionally notify the user via email
        if ($request->boolean('notify')) {
            try {
                $user->notify(new \App\Notifications\UserActionNotification(
                    'password_reset_by_admin',
                    'reset your password',
                    'An administrator has reset your account password. If this was unexpected, contact support immediately.',
                    route('login'),
                    'Security Notice'
                ));
            } catch (\Throwable $e) {
                // Swallow notification errors, proceed with success
            }
        }

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Password updated successfully for the user.');
    }

    public function sendFeaturedAdEmail(Request $request, \App\Models\JobPosting $job)
    {
        $validated = $request->validate([
            'email_to' => 'required|email',
            'email_subject' => 'required|string|max:255',
            'payment_link' => 'required|url',
            'email_message' => 'required|string|max:5000',
        ]);

        try {
            // Replace [PAYMENT_LINK] placeholder with actual payment link
            $message = str_replace('[PAYMENT_LINK]', $validated['payment_link'], $validated['email_message']);

            // Send email using Laravel's mail system
            \Illuminate\Support\Facades\Mail::raw($message, function ($mailMessage) use ($validated) {
                $mailMessage->to($validated['email_to'])
                        ->subject($validated['email_subject'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->back()
                ->with('success', 'Payment link email sent successfully to ' . $validated['email_to']);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}



