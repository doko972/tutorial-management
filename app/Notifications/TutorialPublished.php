<?php

namespace App\Notifications;

use App\Models\Tutorial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TutorialPublished extends Notification
{
    use Queueable;

    protected $tutorial;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tutorial $tutorial)
    {
        $this->tutorial = $tutorial;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tutorial_id' => $this->tutorial->id,
            'tutorial_title' => $this->tutorial->title,
            'tutorial_slug' => $this->tutorial->slug,
            'branch_name' => $this->tutorial->branch->name,
            'branch_color' => $this->tutorial->branch->color,
            'author_name' => $this->tutorial->author->name,
            'message' => "Un nouveau tutoriel '{$this->tutorial->title}' a été publié dans la branche {$this->tutorial->branch->name}.",
        ];
    }
}