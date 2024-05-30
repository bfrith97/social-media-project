<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUserInformation(): ?array
    {
        if (Auth::check()) {
            $user = User::with([
                'conversations',
                'conversations.conversationParticipants' => function ($q) {
                    $q->whereNot('user_id', Auth::id());
                },
                'conversations.messages',
                'conversations.messages.user',
            ])
                ->withCount('conversations')
                ->find(Auth::id());

            $conversations = $user->conversations;
            $notificationsCount = $user->unreadNotifications->count();

            return [$user, $conversations, $notificationsCount];
        } else {
            return null;
        }
    }
}
