<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollower extends Notification implements ShouldQueue
{
    use Queueable;

    public User $follower;

    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }


    public function via($notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->follower->name} started following you",
            'href' => route('profiles.show', $this->follower->id),
            'picture' => $this->follower->profile_picture,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('New Follow Notification')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line($this->follower->name . ' has just followed you ')
            ->action('View follower', route('profiles.show', $this->follower->id))
            ->line('Thank you for using Connex!');
    }
}
