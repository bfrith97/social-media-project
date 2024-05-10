<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $commenter;

    public function __construct(User $commenter)
    {
        $this->commenter = $commenter;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->commenter->name} commented on your post",
            'href' => route('profiles.show', $this->commenter->id),
            'picture' => $this->commenter->picture
        ];
    }
}
