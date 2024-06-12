<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewFollower;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class ProfileService extends ParentService
{
    public function getProfile($id)
    {
        $profile = User::with([
            'relationship',
            'partner',
            'followings',
            'followers',
            'ownPosts' => function ($query) use ($id) {
                $query->whereNull('group_id')
                    ->where(function ($subQuery) use ($id) {
                        $subQuery->whereNull('profile_id')
                            ->orWhere('profile_id', $id);
                    })
                    ->orderBy('created_at', 'desc');
            },
            'otherPosts'
        ])
            ->where('users.id', $id)
            ->firstOrFail();

        $combinedPosts = $profile->ownPosts->merge($profile->otherPosts);
        $combinedPosts = $combinedPosts->sortByDesc('created_at');

        return [$profile, $combinedPosts];
    }

    public function getProfileActivity($id)
    {
        return Activity::with('causer')->where('causer_id', $id)->orderByDesc('created_at')->get();
    }

    public function updateProfile(Request $request)
    {
        $request->user()
            ->fill($request->validated());

        if ($request->user()
            ->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()
            ->save();
    }

    public function destroyProfile(Request $request): ?bool
    {
        $request->validateWithBag('userDeletion', [
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()
            ->invalidate();
        $request->session()
            ->regenerateToken();
    }

    public function loadAdditionalPosts($id, $offset)
    {
        $limit = 5;

        $validatedData = Validator::make([
            'offset' => $offset,
        ], [
            'offset' => 'required|integer',
        ])
            ->getData();

        $profile = User::findOrFail($id);
        $posts = $profile->ownPosts()->with([
            'comments' => function ($q) {
                return $q->limit(5);
            },
            'comments.user',
            'comments.commentLikes',
            'postLikes'
        ])
            ->whereNull('group_id')
            ->orderByDesc('created_at')
            ->skip($offset)
            ->take($limit + 1)
            ->get();

        $morePostsAvailable = $posts->count() > $limit;
        if ($morePostsAvailable) {
            $posts->pop();
        }

        foreach($posts as &$post) {
            $post->image_path = asset($post->image_path) . 123;
        }

        return [$posts, $morePostsAvailable, $validatedData];
    }
}
