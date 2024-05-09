<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewLike extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $liker;

    public function __construct(User $liker)
    {
        $this->liker = $liker;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->liker->name} liked your post.",
            'href' => route('profiles.show', $this->liker->id),
        ];
    }
}
