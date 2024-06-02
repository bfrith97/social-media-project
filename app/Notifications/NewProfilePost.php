<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProfilePost extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $poster;
    protected Post $post;

    public function __construct(User $poster, Post $post)
    {
        $this->poster = $poster;
        $this->post = $post;
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
            'message' => "{$this->poster->name} posted on your profile",
            'href' => route('profiles.show', $this->poster->id),
            'picture' => $this->poster->profile_picture,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('New Profile Post Notification')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line($this->poster->name . ' posted to your profile')
            ->action('View post', route('posts.show', $this->post->id))
            ->line('Thank you for using Connex!');
    }
}
