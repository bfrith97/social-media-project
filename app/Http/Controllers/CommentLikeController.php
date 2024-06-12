<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use App\Services\CommentLikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentLikeController extends Controller
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
    public function store(Request $request): ?JsonResponse
    {
        $response = $this->commentLikeService->storeCommentLike($request);
        if (!$response['success']) {
            return $this->commentLikeService->returnErrorResponse($response, __METHOD__);
        }

        [$like, $type, $comment] = $response['data'];
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
    public function destroy(Request $request)
    {
        $response = $this->commentLikeService->destroyCommentLike($request);
        if (!$response['success']) {
            return $this->commentLikeService->returnErrorResponse($response, __METHOD__);
        }

        return response()->json([
            'message' => 'Like removed successfully',
        ]);
    }
}
