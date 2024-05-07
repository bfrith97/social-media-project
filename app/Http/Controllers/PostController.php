<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $posts = Post::with('user', 'comments', 'comments.user', 'comments.likes', 'postLikes')
            ->orderByDesc('created_at')
            ->get();

        $usersToFollow = User::whereDoesntHave('followers', function ($query) use ($user) {
            $query->where('follower_id', $user->id);
        })
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('posts.index')->with([
            'user' => Auth::user(),
            'usersToFollow' => $usersToFollow,
            'posts' => $posts,
        ]);
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
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        $post = Post::create($validatedData);

        return response()->json([
            'message' => 'Post added successfully',
            'post' => [
                'id' => $post->id,
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'role' => $post->user->role,
                    'company' => $post->user->company,
                    'picture' => asset($post->user->picture),
                ],
                'content' => $post->content,
                'comment_route' => route('comments.store'),
                'csrf' => csrf_token(),
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
