<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\JobPosting;
use App\Notifications\DailyJobAlerts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendDailyJobAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:send-daily-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 10 new jobs to registered users at midnight';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting daily job alerts...');

        // Get all registered users (verified email, active status)
        $users = User::where('status', 'active')
            ->whereNotNull('email_verified_at')
            ->whereHas('role', function($q) {
                $q->where('slug', 'seeker');
            })
            ->get();

        if ($users->isEmpty()) {
            $this->info('No registered users found.');
            return;
        }

        // Get 10 newest published jobs from the last 24 hours
        $newJobs = JobPosting::where('status', 'published')
            ->where('created_at', '>=', now()->subDay())
            ->with(['employer.employerProfile', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($newJobs->isEmpty()) {
            $this->info('No new jobs found in the last 24 hours.');
            return;
        }

        $this->info('Found ' . $newJobs->count() . ' new jobs.');
        $this->info('Sending alerts to ' . $users->count() . ' users...');

        $sentCount = 0;
        $failedCount = 0;

        foreach ($users as $user) {
            try {
                $user->notify(new DailyJobAlerts($newJobs->toArray()));
                $sentCount++;
                
                if ($sentCount % 10 == 0) {
                    $this->line("Sent to {$sentCount} users...");
                }
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Failed to send daily job alert to user: ' . $user->id, [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                ]);
            }
        }

        $this->info("Daily job alerts completed!");
        $this->info("Successfully sent: {$sentCount}");
        $this->info("Failed: {$failedCount}");

        Log::info('Daily job alerts sent', [
            'total_users' => $users->count(),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'jobs_count' => $newJobs->count(),
        ]);
    }
}

