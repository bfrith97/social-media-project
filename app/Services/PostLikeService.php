<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewFollower;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storePostLike(Request $request): Model|PostLike
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $post = Post::with('user')
            ->find($validatedData['post_id']);
        $like = $post->postLikes()
            ->createOrFirst($validatedData);

        $this->notificationService->notifyUserPostLike($post, $like);

        return $like;
    }

    public function destroyPostLike(Request $request): ?bool
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        return PostLike::where($validatedData)
            ->delete();
    }
}
