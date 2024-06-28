<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentLikeRequest;
use App\Services\ActivityService;
use App\Services\CommentLikeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentLikeController extends BaseController
{
    private CommentLikeService $commentLikeService;
    private ActivityService $activityService;

    public function __construct(CommentLikeService $commentLikeService, ActivityService $activityService)
    {
        $this->commentLikeService = $commentLikeService;
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
    public function store(CommentLikeRequest $request): ?JsonResponse
    {
        try {
            [$like, $type, $comment] = $this->commentLikeService->storeCommentLike($request);

            $this->activityService->storeActivity($like, "$type.show", $comment->item_id, 'bi bi-hand-thumbs-up', 'liked a comment');

            return response()->json([
                'message' => 'Like added successfully',
                'like' => [
                    'user' => [
                        'id' => $like->user->id,
                        'name' => $like->user->name,
                        'picture' => $like->user->profile_picture ? asset($like->user->profile_picture) : '',
                    ],
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
    public function destroy(CommentLikeRequest $request)
    {
        try {
            $this->commentLikeService->destroyCommentLike($request);

            return response()->json([
                'message' => 'Like removed successfully',
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }
}
