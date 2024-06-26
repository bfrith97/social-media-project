<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLike extends Notification implements ShouldQueue
{
    use Queueable;

    public User $liker;
    public Model $model;
    public string $item;

    public function __construct(User $liker, Model $model, string $item)
    {
        $this->liker = $liker;
        $this->model = $model;
        $this->item = $item;
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
        if(isset($this->model->post->id)) $route = 'posts.show';
        if(isset($this->model->newsArticle->id)) $route = 'news.show';

        return [
            'message' => "{$this->liker->name} liked your " . $this->item,
            'href' => route($route, $this->model->post->id ?? $this->model->newsArticle->id ?? $this->model->id),
            'picture' => $this->liker->profile_picture,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->subject('New Like Notification')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line($this->liker->name . ' liked your ' . $this->item)
            ->action('View ' . ucfirst($this->item), route('posts.show', $this->model->post->id ?? $this->model->id))
            ->line('Thank you for using Connex!');
    }
}
