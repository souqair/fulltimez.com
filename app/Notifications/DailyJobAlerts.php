<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DailyJobAlerts extends Notification
{
    use Queueable;

    public Collection $jobs;

    public function __construct(Collection $jobs)
    {
        $this->jobs = $jobs;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Your Daily Job Alerts from FullTimez!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Here are some new job postings that might interest you:');

        foreach ($this->jobs as $job) {
            $companyName = 'N/A';
            if ($job->employer && $job->employer->employerProfile) {
                $companyName = $job->employer->employerProfile->company_name ?? 'N/A';
            }
            
            $location = trim(($job->location_city ?? '') . ', ' . ($job->location_country ?? ''), ', ');
            $salary = $job->salary_min ? 'AED ' . number_format($job->salary_min) . ($job->salary_period ? '/' . $job->salary_period : '') : 'Negotiable';
            $jobUrl = route('jobs.show', $job->slug);
            
            $mailMessage->line('**' . $job->title . '** at ' . $companyName)
                       ->line('Location: ' . ($location ?: 'N/A'))
                       ->line('Salary: ' . $salary)
                       ->line('View Job: ' . $jobUrl)
                       ->line('---');
        }

        $mailMessage->line('')
                   ->line('Log in to your dashboard to explore more opportunities!')
                   ->action('Browse All Jobs', route('jobs.index'))
                   ->line('Thank you for using FullTimez!');

        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New job opportunities',
            'message' => 'We found ' . $this->jobs->count() . ' new job opportunities for you.',
            'action_text' => 'Browse Jobs',
            'action_url' => route('jobs.index'),
            'jobs_count' => $this->jobs->count(),
        ];
    }
}

