<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUserInformation(): array|RedirectResponse
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
            return redirect()->route('login');
        }
    }

    public function getSuggestedUsers(User $user)
    {
        return User::where('id', '!=', $user->id)
            ->whereDoesntHave('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })
            ->inRandomOrder()
            ->take(5)
            ->get();
    }
}
