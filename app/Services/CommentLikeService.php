<?php

namespace App\Services;

use App\Http\Requests\CommentLikeRequest;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CommentLikeService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storeCommentLike(CommentLikeRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            $comment = Comment::with('user', 'commentLikes')
                ->find($validatedData['comment_id']);
            $like = $comment->commentLikes()
                ->createOrFirst($validatedData);
            $type = $comment->item_type === Post::class ? 'posts' : 'news';
            $comment->load($type === 'posts' ? 'post' : 'newsArticle');

            $this->notificationService->notifyUserOfCommentLike($like, $comment);

            return [$like, $type, $comment];
        });
    }

    public function destroyCommentLike(CommentLikeRequest $request)
    {
        $this->validateUser($request);
        $validatedData = $request->validated();

        return CommentLike::where($validatedData)
            ->delete();
    }
}
