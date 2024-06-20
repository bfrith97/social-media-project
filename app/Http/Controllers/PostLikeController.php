<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostLikeRequest;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Notifications\NewLike;
use App\Services\ActivityService;
use App\Services\PostLikeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostLikeController extends BaseController
{
    private PostLikeService $postLikeService;
    private ActivityService $activityService;

    public function __construct(PostLikeService $postLikeService, ActivityService $activityService)
    {
        $this->postLikeService = $postLikeService;
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
    public function store(PostLikeRequest $request): ?JsonResponse
    {
        try {
            $like = $this->postLikeService->storePostLike($request);

            $this->activityService->storeActivity($like, 'posts.show', $like->post_id, 'bi bi-hand-thumbs-up', 'liked a post');

            return response()->json([
                'message' => 'Like added successfully',
                'like' => [
                    'id' => $like->id,
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
    public function destroy(PostLikeRequest $request): ?JsonResponse
    {
        try {
            $this->postLikeService->destroyPostLike($request);

            return response()->json([
                'message' => 'Like removed successfully',
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }
}
