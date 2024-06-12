<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationService extends ParentService
{
    public function storeConversation(Request $request)
    {
        $userID = Auth::id();
        $otherUserID = $request->user_id;

        // Check for existing conversation between the authenticated user and the requested user
        $conversation = Conversation::findByParticipants($userID, $otherUserID);
        $newConversation = false;

        if (!$conversation) {
            // If no conversation exists, create a new one
            $conversation = Conversation::create();
            $newConversation = true;

            // Create participants for the new conversation
            ConversationParticipant::firstOrCreate([
                'conversation_id' => $conversation->id,
                'user_id' => $userID,
            ]);

            $participant = ConversationParticipant::firstOrCreate([
                'conversation_id' => $conversation->id,
                'user_id' => $otherUserID,
            ]);

            $participant->load('participant');

            $participant->participant->profile_picture = asset($participant->participant->profile_picture);
            $participant->participant->profile_route = route('profiles.show', $participant->participant->id);
        }

        $conversation->created_at_formatted = Carbon::parse($conversation->created_at)->format('D, d M Y - H:i');

        return [$conversation, $participant, $newConversation];
    }
}
