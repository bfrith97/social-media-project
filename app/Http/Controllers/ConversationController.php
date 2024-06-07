<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\MessageService;
use App\Services\NewsService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return response()->json([
            'conversation' => $conversation,
            'participant' => $participant ?? null,
            'isNewConversation' => $newConversation,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUsersForNewChat(Request $request)
    {
        //
    }
}
