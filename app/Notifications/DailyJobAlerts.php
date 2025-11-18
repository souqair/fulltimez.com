<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobPosting;

class DailyJobAlerts extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly array $jobs
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('New Job Opportunities - ' . now()->format('F j, Y'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We found ' . count($this->jobs) . ' new job opportunities that might interest you:');

        // Add job listings
        foreach ($this->jobs as $job) {
            $mailMessage->line('')
                       ->line('**' . $job->title . '**')
                       ->line('Company: ' . ($job->employer->employerProfile->company_name ?? 'N/A'))
                       ->line('Location: ' . $job->location_city . ', ' . $job->location_country)
                       ->line('Salary: ' . ($job->salary_range ?? 'Negotiable'))
                       ->action('View Job', route('jobs.show', $job->slug));
        }

        $mailMessage->line('')
                   ->line('Browse more jobs on FullTimez and find your perfect match!')
                   ->action('Browse All Jobs', route('jobs.index'))
                   ->line('Thank you for using FullTimez!');

        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New job opportunities',
            'message' => 'We found ' . count($this->jobs) . ' new job opportunities for you.',
            'action_text' => 'Browse Jobs',
            'action_url' => route('jobs.index'),
            'jobs_count' => count($this->jobs),
        ];
    }
}

