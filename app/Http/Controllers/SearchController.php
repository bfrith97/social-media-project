<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $currentUserId = Auth::id();

        $users = User::select('id', 'name', 'picture', 'role')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->take(7)
            ->map(function ($user) {
                $user->user = true;
                return $user;
            });

        $groups = Group::select('id', 'name')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->take(7)
            ->map(function ($group) {
                $group->group = true;
                return $group;
            });

        foreach ($groups as &$group) {
            $group['subtitle'] = 'Group';
        }

        $results = $groups->concat($users);

        foreach ($results as &$result) {
            $result['subtitle'] = $result['followed_by_current_user'] ? 'Following' : $result['role'];
            if (!$result['subtitle']) $result['subtitle'] = $result['user'] && $result['id'] == $currentUserId ? 'You' : null;
            if (!$result['subtitle']) $result['subtitle'] = $result['group'] ? 'Group' : null;
        }

        return $results;
    }
}
