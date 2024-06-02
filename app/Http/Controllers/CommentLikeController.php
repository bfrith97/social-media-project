<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Notifications\NewLike;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    private ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
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
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $comment = Comment::with('user')->find($validatedData['comment_id']);
        $like = $comment->commentLikes()->createOrFirst($validatedData);

        $comment->user->notify(new NewLike($like->user, $comment,'comment'));

        $type = $comment->item_type === Post::class ? 'posts' : 'news';

        $this->activityService->storeActivity($like, "$type.show", $comment->item_id, 'bi bi-hand-thumbs-up', 'liked a comment');

        if ($like) {
            return response()->json([
                'message' => 'Like added successfully',
                'like' => [
                    'id' => $like->id,
                    'user' => [
                        'id' => $like->user->id,
                        'name' => $like->user->name,
                        'picture' => asset($like->user->profile_picture),
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
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $deleted = CommentLike::where($validatedData)
            ->delete();

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
