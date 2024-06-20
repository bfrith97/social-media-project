<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\ActivityService;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends BaseController
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
    public function store(CommentRequest $request): ?JsonResponse
    {
        try {
            $response = $this->commentService->storeComment($request);

            [$comment, $model, $itemType] = $response['data'];
            $this->activityService->storeActivity($model, "$itemType.show", $comment->item_id, 'bi bi-chat-left-dots', 'commented on a post');

            return response()->json([
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment->id,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'picture' => $comment->user->profile_picture ? asset($comment->user->profile_picture) : '',
                    ],
                    'likeCommentRoute' => route('comment_likes.store'),
                    'csrf' => csrf_token(),
                    'content' => $comment->content,
                ],
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
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
    public function loadAdditional($post, $offset): ?JsonResponse
    {
        try {
            [$comments, $moreCommentsAvailable, $validatedData] = $this->commentService->loadAdditionalComments($post, $offset);

            return response()->json([
                'message' => 'Comments retrieved successfully',
                'comments' => $comments,
                'moreCommentsAvailable' => $moreCommentsAvailable,
                'newOffset' => $validatedData['offset'] + 5,
                'likeCommentRoute' => route('comment_likes.store'),
                'csrf' => csrf_token(),
            ]);

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
