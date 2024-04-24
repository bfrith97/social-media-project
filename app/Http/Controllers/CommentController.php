<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class CommentController extends Controller
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
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])->strict(false)->strictClean(true)->filter();

        $comment = Comment::create($validatedData);
        $commentNumber = Comment::where('post_id', $validatedData['post_id'])->count();

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => [
                'id' => $comment->id,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'picture' => asset($comment->user->picture),
                ],
                'content' => $comment->content,
                'comment_count' => $commentNumber,
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
}