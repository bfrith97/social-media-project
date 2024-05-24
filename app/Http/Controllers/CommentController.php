<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\NewsArticle;
use App\Models\Post;
use App\Notifications\NewComment;
use App\Notifications\NewLike;
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
            'item_id' => 'required|integer',
            'item_type_id' => 'required|integer|exists:comment_item_types,id',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        switch ($validatedData['item_type_id']) {
            case 1:
                $post = Post::with('user')
                    ->find($validatedData['item_id']);

                $comment = $post->comments()
                    ->create($validatedData);

                $post->user->notify(new NewComment($comment->user, $post));
                break;

            case 2:
                $article = NewsArticle::find($validatedData['item_id']);

                $comment = $article->comments()
                    ->create($validatedData);
                break;
        }

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
