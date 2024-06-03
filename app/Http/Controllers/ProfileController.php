<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;


class ProfileController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

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
                    ->orderBy('created_at', 'desc')
                    ->limit(5); // Limiting posts here
            },
            'otherPosts' => function ($query) {
                $query->limit(5);
            }
        ])
            ->where('users.id', $id)
            ->firstOrFail();

        $combinedPosts = $profile->ownPosts->merge($profile->otherPosts);
        $combinedPosts = $combinedPosts->sortByDesc('created_at');

        $activity = Activity::with('causer')->where('causer_id', $id)->orderByDesc('created_at')->get();

        return view('profiles.show')->with([
            'profile' => $profile,
            'combinedPosts' => $combinedPosts,
            'activity' => $activity,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations
        ]);
    }

    /**
     * Update the user's profiles-breeze information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()
            ->fill($request->validated());

        if ($request->user()
            ->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()
            ->save();

        return Redirect::route('profiles-breeze.edit')
            ->with('status', 'profiles-breeze-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
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

        return Redirect::to('/');
    }

    public function loadAdditionalPosts($id, $offset)
    {
        [$user] = $this->userService->getUserInformation();

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

        return response()->json([
            'message' => 'Posts retrieved successfully',
            'posts' => $posts,
            'morePostsAvailable' => $morePostsAvailable,
            'newOffset' => $validatedData['offset'] + 5,
            'user' => $user,
            'commentPostRoute' => route('comments.store'),
            'csrf' => csrf_token(),
        ]);
    }

}
