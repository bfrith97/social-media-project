<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use App\Services\FollowService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    private FollowService $followService;
    private ActivityService $activityService;
    private UserService $userService;

    public function __construct(FollowService $followService, ActivityService $activityService, UserService $userService)
    {
        $this->followService = $followService;
        $this->activityService = $activityService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        $usersToFollow = $this->followService->getUsersToFollow();

        return view('who_to_follow.index')->with([
            'user' => $user,
            'conversations' => $conversations,
            'notificationsCount' => $notificationsCount,
            'usersToFollow' => $usersToFollow,
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
    public function store(Request $request): ?JsonResponse
    {
        $response = $this->followService->storeFollow($request);
        if (!$response['success']) {
            return $this->followService->returnErrorResponse($response, __METHOD__);
        }

        [$follow, $followee] = $response['data'];
        $this->activityService->storeActivity($follow, 'profiles.show', $follow->followee_id, 'bi bi-person-add', 'followed ' . $followee->name);

        if ($follow) {
            return response()->json([
                'message' => 'Follow added successfully',
            ]);
        }
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
    public function edit()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): ?JsonResponse
    {
        $response = $this->followService->destroyFollow($request);
        if (!$response['success']) {
            return $this->followService->returnErrorResponse($response, __METHOD__);
        }

        return response()->json([
            'message' => 'Follow removed successfully',
        ]);
    }
}
