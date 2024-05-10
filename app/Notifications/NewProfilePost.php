<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewProfilePost extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $poster;

    public function __construct(User $poster)
    {
        $this->poster = $poster;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->poster->name} posted on your profile",
            'href' => route('profiles.show', $this->poster->id),
            'picture' => $this->poster->picture
        ];
    }
}
