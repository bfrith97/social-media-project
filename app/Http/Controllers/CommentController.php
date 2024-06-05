<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\NewsArticle;
use App\Models\Post;
use App\Notifications\NewComment;
use App\Notifications\NewLike;
use App\Services\ActivityService;
use App\Services\CommentService;
use Carbon\Carbon;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    private CommentService $commentService;
    private ActivityService $activityService;

    public function __construct(CommentService $commentService, ActivityService $activityService)
    {
        $this->commentService = $commentService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        [$comment, $model, $itemType] = $this->commentService->storeComment($request);

        $this->activityService->storeActivity($model, "$itemType.show", $comment->item_id, 'bi bi-chat-left-dots', 'commented on a post');

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => [
                'id' => $comment->id,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'picture' => asset($comment->user->profile_picture),
                ],
                'likeCommentRoute' => route('comment_likes.store'),
                'csrf' => csrf_token(),
                'content' => $comment->content,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function loadAdditional($post, $offset)
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
            $comment->user->profile_picture = asset($comment->user->profile_picture);
        }

        if ($comments) {
            return response()->json([
                'message' => 'Comments retrieved successfully',
                'comments' => $comments,
                'moreCommentsAvailable' => $moreCommentsAvailable,
                'newOffset' => $validatedData['offset'] + 5,
                'likeCommentRoute' => route('comment_likes.store'),
                'csrf' => csrf_token()
            ]);
        } else {
            return response()->json([
                'message' => 'Comments not found',
            ]);
        }
    }
}
