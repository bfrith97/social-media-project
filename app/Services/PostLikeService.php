<?php

namespace App\Services;

use App\Http\Requests\PostLikeRequest;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostLikeService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storePostLike(PostLikeRequest $request): Model|PostLike
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            $post = Post::with('user')
                ->findOrFail($validatedData['post_id']);
            $like = $post->postLikes()
                ->createOrFirst($validatedData);

            $this->notificationService->notifyUserPostLike($post, $like);

            return $like;
        });
    }

    public function destroyPostLike(PostLikeRequest $request): ?bool
    {
        $this->validateUser($request);
        $validatedData = $request->validated();

        return PostLike::where($validatedData)
            ->delete();
    }
}
