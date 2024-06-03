<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use App\Services\ActivityService;
use App\Services\NewsService;
use App\Services\UserService;
use Carbon\Carbon;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class PostController extends Controller
{
    private UserService $userService;
    private NewsService $newsService;
    private ActivityService $activityService;

    public function __construct(UserService $userService, NewsService $newsService, ActivityService $activityService)
    {
        $this->userService = $userService;
        $this->newsService = $newsService;
        $this->activityService = $activityService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [
            $user,
            $conversations,
            $notificationsCount,
        ] = $this->userService->getUserInformation();

        $posts = Post::with([
            'user',
            'comments' => function ($q) {
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
            ->limit(5)
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
            'user' => $user,
            'notificationsCount' => $notificationsCount,
            'conversations' => $conversations,
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
            'is_feeling' => 'nullable|boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['content'] = Profanity::blocker($validatedData['content'])
            ->strict(false)
            ->strictClean(true)
            ->filter();

        if ($request->hasFile('image_path')) {
            $imageName = time() . '.' . $request->image_path->extension();
            $request->image_path->move(public_path('assets/images/posts'), $imageName);
            $validatedData['image_path'] = 'assets/images/posts/' . $imageName;
        } else {
            unset($validatedData['profile_picture']);
        }

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
                    'profile_picture' => asset($post->user->profile_picture),
                ],
                'content' => $post->content,
                'image_path' => $post->image_path,
                'comment_route' => route('comments.store'),
                'is_feeling' => $post->is_feeling,
            ],
            'csrf' => csrf_token(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        [
            $user,
            $conversations,
            $notificationsCount,
        ] = $this->userService->getUserInformation();

        $post = Post::with('user')
            ->find($id);
        if (!$post) {
            return redirect()->back();
        }

        return view('posts.show')->with([
            'post' => $post,
            'user' => $user,
            'notificationsCount' => $notificationsCount,
            'conversations' => $conversations,
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

    /**
     * Store a newly created resource in storage.
     */
    public function loadAdditional($offset)
    {
        [$user] = $this->userService->getUserInformation();

        $limit = 5;

        $validatedData = Validator::make([
            'offset' => $offset,
        ], [
            'offset' => 'required|integer',
        ])
            ->getData();

        $posts = Post::with([
            'user',
            'comments' => function ($q) {
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
            ->skip($validatedData['offset'])
            ->limit($limit + 1)
            ->withCount('comments', 'postLikes')
            ->get();

        $morePostsAvailable = $posts->count() > $limit;

        if ($morePostsAvailable) {
            $posts->pop();
        }

        foreach ($posts as &$post) {
            $post->created_at_formatted = Carbon::parse($post->created_at)
                ->timezone('Europe/London')
                ->diffForHumans();

            $post->user->profile_picture = asset($post->user->profile_picture);
            $post->user->profile_route = route('profiles.show', $post->user->id);
            $post->image_path = asset($post->image_path);

            foreach ($post->comments as &$comment) {
                $comment->created_at_formatted = Carbon::parse($comment->created_at)
                    ->timezone('Europe/London')
                    ->diffForHumans();;
                $comment->user->profile_picture = asset($comment->user->profile_picture);
                $comment->user->profile_route = route('profiles.show', $comment->user->id);
            }
        }

        $user->profile_picture = asset($user->profile_picture);
        $user->profile_route = route('profiles.show', $user->id);


        if ($posts) {
            return response()->json([
                'message' => 'Posts retrieved successfully',
                'posts' => $posts,
                'morePostsAvailable' => $morePostsAvailable,
                'newOffset' => $validatedData['offset'] + 5,
                'user' => $user,
                'commentPostRoute' => route('comments.store'),
                'csrf' => csrf_token(),
            ]);
        } else {
            return response()->json([
                'message' => 'Posts not found',
            ]);
        }
    }
}
