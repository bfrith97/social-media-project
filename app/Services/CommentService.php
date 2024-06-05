<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storeComment(Request $request): JsonResponse|array
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:App\Models\Post,App\Models\NewsArticle',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        $model = $validatedData['item_type']::find($validatedData['item_id']);
        if (!$model) {
            return response()->json(['error' => 'Invalid item type or ID.'], 404);
        }

        // Create the comment on the model
        $comment = $model->comments()
            ->create($validatedData);

        $this->notificationService->notifyUserOfComment($model, $comment, $validatedData['item_type']);

        $type = $validatedData['item_type'] === Post::class ? 'posts' : 'news';
        return [$comment, $model, $type];
    }
}
