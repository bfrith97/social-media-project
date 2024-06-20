<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\ActivityService;
use App\Services\NewsService;
use App\Services\PostService;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
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
    public function store(PostRequest $request): ?JsonResponse
    {
        try {
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
                        'profile_picture' => $post->user->profile_picture ? asset($post->user->profile_picture) : '',
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

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

            $post = $this->postService->getPost($id);

            return view('posts.show')->with([
                'post' => $post,
                'user' => $user,
                'notificationsCount' => $notificationsCount,
                'conversations' => $conversations,
            ]);

        } catch (Exception $e) {
            return $this->handleException($e);
        }
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
    public function loadAdditional($offset): ?JsonResponse
    {
        [$user] = $this->userService->getUserInformation();
        $this->userService->applyAssetAndRouteToProfileItems($user);

        [$posts, $morePostsAvailable, $validatedData] = $this->postService->loadAdditionalPosts($offset, $user);

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
        }

        return response()->json([
            'message' => 'Posts not found',
        ]);
    }
}
