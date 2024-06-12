<?php

namespace App\Services;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class GroupUserService extends ParentService
{
    public function storeGroupUser(Request $request): GroupUser
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'group_id' => 'required|integer|exists:users,id',
        ]);

        return GroupUser::createOrFirst($validatedData);
    }

    public function destroyGroupUser(Request $request): ?bool
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'group_id' => 'required|integer|exists:users,id',
        ]);

        return GroupUser::where($validatedData)->delete();
    }
}
