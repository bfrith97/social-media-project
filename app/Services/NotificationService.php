<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewFollower;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use Illuminate\Support\Facades\Auth;

class NotificationService extends ParentService
{
    public function notifyUserOfProfilePost($post, $profileId): void
    {
        $user = User::find($profileId);
        if ($post->user_id !== $user->id) {
            $user->notify(new NewProfilePost($post->user, $post));
        }
    }

    public function notifyUserOfComment($model, $comment, $itemType): void
    {
        if ($itemType === 'App\Models\Post') {
            if ($comment->user_id !== $model->user_id) {
                $model->user->notify(new NewComment($comment->user, $model));
            }
        }
    }

    public function notifyUserOfCommentLike($like, $comment): void
    {
        if ($like->user_id !== $comment->user_id) {
            $comment->user->notify(new NewLike($like->user, $comment, 'comment'));
        }
    }

    public function notifyUserOfFollow($followee, $follower): void
    {
        if ($followee->id !== $follower->id) {
            $followee->notify(new NewFollower($follower));
        }
    }

    public function notifyUserPostLike($post, $like): void
    {
        if ($like->user_id !== $post->user_id) {
            $post->user->notify(new NewLike($like->user, $post, 'post'));
        }
    }

    public function markAllNotificationsAsRead(): void
    {
        $user = Auth::user();
        $user->unreadNotifications->markasRead();
    }

}
