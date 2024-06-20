<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function storeComment(CommentRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            $validatedData['content'] = Profanity::blocker($validatedData['content'])
                ->strict(false)
                ->strictClean(true)
                ->filter();

            $model = $validatedData['item_type']::findOrFail($validatedData['item_id']);
            $comment = $model->comments()
                ->create($validatedData);

            $this->notificationService->notifyUserOfComment($model, $comment, $validatedData['item_type']);
            $type = $validatedData['item_type'] === Post::class ? 'posts' : 'news';

            return [
                'success' => true,
                'data' => [$comment, $model, $type],
            ];
        });
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

        return [$comments, $moreCommentsAvailable, $validatedData];
    }
}
