<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewFollower extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $follower;

    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->follower->name} started following you",
            'href' => route('profiles.show', $this->follower->id),
            'picture' => $this->follower->picture
        ];
    }
}
