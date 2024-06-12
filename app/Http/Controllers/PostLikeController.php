<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Notifications\NewLike;
use App\Services\ActivityService;
use App\Services\PostLikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostLikeController extends Controller
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
    public function store(Request $request): ?JsonResponse
    {
        $like = $this->postLikeService->storePostLike($request);

        $this->activityService->storeActivity($like, 'posts.show', $like->post_id, 'bi bi-hand-thumbs-up', 'liked a post');

        if ($like) {
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
        } else {
            return response()->json([
                'message' => 'Like not added',
            ]);
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
    public function destroy(Request $request): ?JsonResponse
    {
        $deleted = $this->postLikeService->destroyPostLike($request);

        if ($deleted) {
            return response()->json([
                'message' => 'Like removed successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Like not removed',
            ]);
        }
    }
}
