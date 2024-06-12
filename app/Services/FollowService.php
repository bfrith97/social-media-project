<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewFollower;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowService extends ParentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getUsersToFollow()
    {
        $user = Auth::user();

        if ($user) {
            return User::where('id', '!=', $user->id)
                ->whereDoesntHave('followers', function ($query) use ($user) {
                    $query->where('follower_id', $user->id);
                })
                ->inRandomOrder()
                ->get();
        }
    }

    public function storeFollow(Request $request): array
    {
        $validatedData = $request->validate([
            'follower_id' => 'required|integer|exists:users,id',
            'followee_id' => 'required|integer|exists:users,id',
        ]);

        if ($validatedData['follower_id'] != Auth::id()) {
            return [
                'success' => false,
                'error' => 'User ID mismatch',
                'code' => 401,
            ];
        }

        $follow = Follow::create($validatedData);

        $follower = User::find($validatedData['follower_id']);
        $followee = User::find($validatedData['followee_id']);

        $this->notificationService->notifyUserOfFollow($followee, $follower);

        return [
            'success' => true,
            'data' => [$follow, $followee],
        ];
    }

    public function destroyFollow(Request $request): array|bool
    {
        $validatedData = $request->validate([
            'follower_id' => 'required|integer|exists:users,id',
            'followee_id' => 'required|integer|exists:users,id',
        ]);

        if ($validatedData['follower_id'] != Auth::id()) {
            return [
                'success' => false,
                'error' => 'User ID mismatch',
                'code' => 401,
            ];
        }

        return Follow::where($validatedData)
            ->delete();
    }
}
