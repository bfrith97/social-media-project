<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class NewLike extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $liker;
    protected Model $model;
    protected string $item;

    public function __construct(User $liker, Model $model, string $item)
    {
        $this->liker = $liker;
        $this->model = $model;
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
            'href' => route('posts.show', $this->model->post->id ?? $this->model->id),
            'picture' => $this->liker->picture
        ];
    }
}
