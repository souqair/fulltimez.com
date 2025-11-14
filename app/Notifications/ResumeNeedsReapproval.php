<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResumeNeedsReapproval extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $seekerUserId,
        public readonly string $seekerName
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Resume needs re-approval',
            'message' => $this->seekerName . ' has updated their CV and it requires re-approval.',
            'action_text' => 'Review Resume',
            'action_url' => route('admin.users.show', $this->seekerUserId),
            'seeker_user_id' => $this->seekerUserId,
            'seeker_name' => $this->seekerName,
        ];
    }
}

