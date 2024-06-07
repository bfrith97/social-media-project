<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ActivityService;
use App\Services\NewsService;
use App\Services\PostService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private PostService $postService;
    private UserService $userService;
    private NewsService $newsService;
    private ActivityService $activityService;

    public function __construct(PostService $postService, UserService $userService, NewsService $newsService, ActivityService $activityService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->newsService = $newsService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        [$posts, $moreLoadable] = $this->postService->getFeedPosts($user);
        $usersToFollow = $this->userService->getSuggestedUsers($user);
        $news = $this->newsService->getNewsHeadlines();

        return view('posts.index')->with([
            'usersToFollow' => $usersToFollow,
            'posts' => $posts,
            'moreLoadable' => $moreLoadable,
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
        $post = $this->postService->storePost($request);

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
                    'profile_route' => route('profiles.show', $post->user->id),
                ],
                'content' => $post->content,
                'image_path' => $post->image_path,
                'comment_route' => route('comments.store'),
                'post_like_route' => route('post_likes.store'),
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
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $post = $this->postService->getPost($id);

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
                'comment_post_route' => route('comments.store'),
                'like_post_route' => route('post_likes.store'),
                'like_comment_route' => route('comment_likes.store'),
                'csrf' => csrf_token(),
            ]);
        } else {
            return response()->json([
                'message' => 'Posts not found',
            ]);
        }
    }
}
