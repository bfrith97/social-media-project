<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $commenter;
    protected Post $post;

    public function __construct(User $commenter, Post $post)
    {
        $this->commenter = $commenter;
        $this->post = $post;
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "{$this->commenter->name} commented on your post",
            'href' => route('posts.show', $this->post->id),
            'picture' => $this->commenter->picture
        ];
    }
}
