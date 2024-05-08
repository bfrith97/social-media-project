<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;

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

        $like = PostLike::create($validatedData);
        $currentLikes = PostLike::with('user')
            ->where('post_id', $validatedData['post_id'])
            ->get();

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
                'current_likes' => $currentLikes,
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
        $currentLikes = PostLike::with('user')
            ->where('post_id', $validatedData['post_id'])
            ->get();

        if ($deleted) {
            return response()->json([
                'message' => 'Like removed successfully',
                'current_likes' => $currentLikes,
            ]);
        } else {
            return response()->json([
                'message' => 'Like not removed',
            ]);
        }
    }
}
