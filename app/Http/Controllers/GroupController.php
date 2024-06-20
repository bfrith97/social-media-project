<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends BaseController
{
    private GroupService $groupService;
    private UserService $userService;

    public function __construct(GroupService $groupService, UserService $userService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        [$allGroups, $mostPopularGroups] = $this->groupService->getGroups();

        return view('groups.index')->with([
            'allGroups' => $allGroups,
            'mostPopularGroups' => $mostPopularGroups,
            'suggestedGroups' => [],
            'notificationsCount' => $notificationsCount,
            'user' => $user,
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
    public function store(Request $request): ?JsonResponse
    {
        try {
            $this->groupService->storeGroup($request);

            return response()->json([
                'message' => 'Group added successfully',
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
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        [$group, $memberNames] = $this->groupService->getGroup($id);

        return view('groups.show')->with([
            'group' => $group,
            'memberNames' => $memberNames,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
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
}
