<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\NewsArticle;
use App\Models\Post;
use App\Notifications\NewComment;
use App\Notifications\NewLike;
use App\Services\ActivityService;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class CommentController extends Controller
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
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:App\Models\Post,App\Models\NewsArticle',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        $model = $validatedData['item_type']::find($validatedData['item_id']);
        if (!$model) {
            return response()->json(['error' => 'Invalid item type or ID.'], 404);
        }

        // Create the comment on the model
        $comment = $model->comments()->create($validatedData);

        if ($validatedData['item_type'] === 'App\Models\Post') {
            $model->user->notify(new NewComment($comment->user, $model));
        }

        $type = $validatedData['item_type'] === Post::class ? 'posts' : 'news';

        $this->activityService->storeActivity($model, "$type.show", $comment->item_id, 'bi bi-chat-left-dots', 'commented on a post');

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
