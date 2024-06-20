<?php

namespace App\Services;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GroupService extends ParentService
{
    public function getGroups(): array
    {
        $groups = Group::with(['members', 'posts', 'posts.user'])
            ->withCount('members', 'posts')
            ->get();

        $allGroups = $groups->sortBy('name');
        $mostPopularGroups = $groups->sortByDesc('members_count');

        return [$allGroups, $mostPopularGroups];
    }

    public function storeGroup(GroupRequest $request): ?bool
    {
        $validatedData = $request->validated();

        return Group::create($validatedData);
    }

    public function getGroup($id): array|RedirectResponse
    {
        $group = Group::with('members', 'posts', 'events', 'groupCategory')
            ->withCount('members', 'posts', 'events')
            ->find($id);
        if (!$group) {
            return redirect()->back();
        }

        $memberNames = $group->members->pluck('name');

        return [$group, $memberNames];
    }
}
