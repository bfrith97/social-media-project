<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use Carbon\Carbon;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    protected function createErrorResponse($message, $error): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => $error,
        ]);
    }

    protected function createSuccessResponse($data): JsonResponse
    {
        [$comment] = $data;
        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $this->formatCommentData($comment),
        ]);
    }

    public function storeComment(Request $request): array
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:App\Models\Post,App\Models\NewsArticle',
        ]);

        if ($validatedData['user_id'] != Auth::id()) {
            return [
                'success' => false,
                'error' => 'User ID mismatch',
                'code' => 401,
            ];
        }

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        $model = $validatedData['item_type']::find($validatedData['item_id']);
        if (!$model) {
            return [
                'success' => false,
                'error' => 'Invalid item type or ID.',
            ];
        }

        $comment = $model->comments()
            ->create($validatedData);

        $this->notificationService->notifyUserOfComment($model, $comment, $validatedData['item_type']);

        $type = $validatedData['item_type'] === Post::class ? 'posts' : 'news';
        return [
            'success' => true,
            'data' => [
                $comment,
                $model,
                $type,
            ],
        ];
    }


    public function loadAdditionalComments($post, $offset)
    {
        $limit = 5;

        $validatedData = Validator::make([
            'post' => $post,
            'offset' => $offset,
        ], [
            'post' => 'required|integer',
            'offset' => 'required|integer',
        ])
            ->getData();

        $comments = Comment::with('user', 'commentLikes')
            ->where('item_id', $validatedData['post'])
            ->orderByDesc('created_at')
            ->skip($validatedData['offset'])
            ->limit($limit + 1)
            ->get();
        $moreCommentsAvailable = $comments->count() > $limit;

        if ($moreCommentsAvailable) {
            $comments->pop();
        }

        foreach ($comments as &$comment) {
            $comment->created_at_formatted = Carbon::parse($comment->created_at)
                ->timezone('Europe/London')
                ->diffForHumans();
            $comment->user->profile_picture = $comment->user->profile_picture ? asset($comment->user->profile_picture) : '';
        }

        return [
            $comments,
            $moreCommentsAvailable,
            $validatedData,
        ];
    }
}
