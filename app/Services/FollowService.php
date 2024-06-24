<?php

namespace App\Services;

use App\Http\Requests\FollowRequest;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function storeFollow(FollowRequest $request): array
    {
        return DB::transaction(function () use ($request) {
            $this->validateUser($request, 'follower_id');
            $validatedData = $request->validated();

            $follow = Follow::createOrFirst($validatedData);

            $follower = User::find($validatedData['follower_id']);
            $followee = User::find($validatedData['followee_id']);

            $this->notificationService->notifyUserOfFollow($followee, $follower);

            return [$follow, $followee];
        });
    }


    public function destroyFollow(FollowRequest $request): array|bool
    {
        return DB::transaction(function () use ($request) {
            $this->validateUser($request, 'follower_id');
            $validatedData = $request->validated();

            return Follow::where($validatedData)
                ->delete();
        });
    }
}
