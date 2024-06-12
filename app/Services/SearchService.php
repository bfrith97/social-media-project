<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Group;
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
use Spatie\Activitylog\Models\Activity;

class SearchService extends ParentService
{
    public function getSearchResults(Request $request)
    {
        $currentUserId = Auth::id();

        $users = User::select('id', 'name', 'profile_picture', 'role')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->take(7)
            ->map(function ($user) {
                $user->user = true;
                return $user;
            });

        foreach ($users as &$user) {
            $user['profile_picture'] = $user->profile_picture ? asset($user->profile_picture) : '';
        }

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
