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

class MessageService
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
        return response()->json(User::select('id', 'name')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->take(7));
    }
}
