<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Notifications\NewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostLikeController extends Controller
{
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
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $post = Post::with('user')->find($validatedData['post_id']);
        $like = $post->postLikes()->create($validatedData);

        $post->user->notify(new NewLike($like->user, $post, 'post'));

        if ($like) {
            return response()->json([
                'message' => 'Like added successfully',
                'like' => [
                    'id' => $like->id,
                    'user' => [
                        'id' => $like->user->id,
                        'name' => $like->user->name,
                        'picture' => asset($like->user->picture),
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
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $deleted = PostLike::where($validatedData)
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
