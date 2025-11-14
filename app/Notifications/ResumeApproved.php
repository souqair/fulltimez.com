<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResumeApproved extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your CV Has Been Approved')
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . '!')
            ->line('Great news! Your CV has been reviewed and approved by our team.')
            ->line('You can now download and share your official FullTimez CV with employers.')
            ->action('Download Your CV', route('resume.preview'))
            ->line('If you make additional changes, your CV will go back into the approval queue for review.')
            ->line('Thanks for keeping your profile up to date with FullTimez!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'CV Approved',
            'message' => 'Your CV has been approved by the admin team. You can now download it.',
            'action_text' => 'View CV',
            'action_url' => route('resume.preview'),
            'type' => 'resume_approved',
        ];
    }
}

