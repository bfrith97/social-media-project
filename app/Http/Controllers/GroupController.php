<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
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
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $groups = Group::with(['members', 'posts', 'posts.user'])
            ->withCount('members', 'posts')
            ->get();

        $allGroups = $groups->sortBy('name');
        $mostPopularGroups = $groups->sortByDesc('members_count');

        // Pass the sorted collections to the view
        return view('groups.index')->with([
            'allGroups' => $allGroups,
            'mostPopularGroups' => $mostPopularGroups,
            'suggestedGroups' => [],
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'private' => 'required|boolean',
        ]);

        Group::create($validatedData);

        return response()->json([
            'message' => 'Post added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $group = Group::with('members', 'posts', 'events', 'groupCategory')->withCount('members', 'posts', 'events')->find($id);
        if(!$group) {
            return redirect()->back();
        }

        $memberNames = $group->members->pluck('name');

        return view('groups.show')->with([
            'group' => $group,
            'memberNames' => $memberNames,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations
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
