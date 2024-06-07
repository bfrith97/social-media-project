<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class PostService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getFeedPosts($user)
    {
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
            ->limit(6)
            ->get();

        $moreLoadable = $posts->count() > 5;
        if ($moreLoadable) {
            $posts->pop();
        }

        return [$posts, $moreLoadable];
    }

    public function storePost(Request $request)
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
            $this->notificationService->notifyUserOfProfilePost($post, $validatedData['profile_id']);
        }

        return $post;
    }

    public function getPost($id)
    {
        $post = Post::with('user')
            ->find($id);
        if (!$post) {
            return redirect()->back();
        }

        return $post;
    }
}
