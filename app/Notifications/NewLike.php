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
    protected string $item;

    public function __construct(User $liker, string $item)
    {
        $this->liker = $liker;
        $this->item = $item;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->liker->name} liked your " . $this->item,
            'href' => route('profiles.show', $this->liker->id),
            'picture' => $this->liker->picture
        ];
    }
}
