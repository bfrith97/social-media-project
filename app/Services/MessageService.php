<?php

namespace App\Services;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageService extends ParentService
{
    public function storeMessage(MessageRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            return Message::create($validatedData);
        });

    }

    public function getUsersForNewChat(Request $request)
    {
        $users = User::whereNot('id', Auth::id())
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        foreach ($users as &$user) {
            $user['profile_picture'] = $user->profile_picture ? asset($user->profile_picture) : '';
            $user['subtitle'] = $user['followed_by_current_user'] ? 'Following' : $user['role'];
        }

        return $users;
    }
}
