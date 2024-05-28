<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use App\Services\ActivityService;
use App\Services\NewsService;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class PostController extends Controller
{
    private NewsService $newsService;
    private ActivityService $activityService;

    public function __construct(NewsService $newsService, ActivityService $activityService) {
        $this->newsService = $newsService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $posts = Post::with([
            'user',
            'comments' => function($q) {
                return $q->limit(5);
            },
            'comments.user',
            'comments.commentLikes',
            'postLikes',
        ])
            ->whereHas('user', function ($query) use ($user) {
                $query->whereHas('followers', function ($subQuery) use ($user) {
                    $subQuery->where('follower_id', $user->id);
                });
                $query->orWhere('user_id', $user->id);
            })
            ->whereNull([
                'group_id',
                'profile_id',
            ])
            ->orderByDesc('created_at')
            ->get();

        $usersToFollow = User::where('id', '!=', $user->id)
            ->whereDoesntHave('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })
            ->inRandomOrder()
            ->take(5)
            ->get();

        $news = $this->newsService->getNewsHeadlines();

        return view('posts.index')->with([
            'usersToFollow' => $usersToFollow,
            'posts' => $posts,
            'news' => $news,
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
            'group_id' => 'nullable|integer|exists:groups,id',
            'profile_id' => 'nullable|integer|exists:users,id',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        $post = Post::create($validatedData);
        $post->load('user');

        if (isset($validatedData['profile_id'])) {
            $user = User::find($validatedData['profile_id']);
            $user->notify(new NewProfilePost($post->user, $post));
        }

        $this->activityService->storeActivity($post, 'posts.show', $post->id, 'bi bi-box-arrow-right', 'created a post');

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
        $post = Post::with('user')
            ->find($id);
        if (!$post) {
            return redirect()->back();
        }

        return view('posts.show')->with([
            'post' => $post,
        ]);
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
