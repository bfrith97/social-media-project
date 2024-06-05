<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class CommentLikeService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storeCommentLike(Request $request): array
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $comment = Comment::with('user')->find($validatedData['comment_id']);
        $like = $comment->commentLikes()->createOrFirst($validatedData);
        $type = $comment->item_type === Post::class ? 'posts' : 'news';
        $comment->load($type == 'posts' ? 'post' : 'newsArticle');

        $this->notificationService->notifyUserOfCommentLike($like, $comment);

        return [$like, $type, $comment];
    }

    public function destroyCommentLike(Request $request): bool
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $deleted = CommentLike::where($validatedData)
            ->delete();

        return $deleted;
    }
}
