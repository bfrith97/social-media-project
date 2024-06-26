<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupUserRequest;
use App\Models\GroupUser;
use App\Services\ActivityService;
use App\Services\GroupUserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupUserController extends BaseController
{
    private GroupUserService $groupUserService;
    private ActivityService $activityService;

    public function __construct(GroupUserService $groupUserService, ActivityService $activityService)
    {
        $this->groupUserService = $groupUserService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(GroupUserRequest $request): ?JsonResponse
    {
        try {
            $groupUser = $this->groupUserService->storeGroupUser($request);
            $this->activityService->storeActivity($groupUser, 'groups.show', $groupUser->group_id, 'bi bi-people', 'joined a group');

            return response()->json([
                'message' => 'Group member added successfully',
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
        //
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
    public function destroy(GroupUserRequest $request): ?JsonResponse
    {
        try {
            $this->groupUserService->destroyGroupUser($request);

            return response()->json([
                'message' => 'Group User removed successfully',
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }
}
