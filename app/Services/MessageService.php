<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageService extends ParentService
{
    public function storeMessage(Request $request)
    {
        $validatedData = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
            'user_id' => 'required|integer|exists:users,id',
            'content' => 'required|string',
        ]);

        return Message::create($validatedData);
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
