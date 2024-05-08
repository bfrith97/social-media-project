<?php

namespace App\Http\Controllers;

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
            ->toArray();

        foreach ($users as &$user) {
            $user['subtitle'] = $user['followed_by_current_user'] ? 'Following' : '';
            if(!$user['subtitle']) $user['subtitle'] = $user['id'] == $currentUserId ? 'You' : '';
        }
        return $users;
    }
}
