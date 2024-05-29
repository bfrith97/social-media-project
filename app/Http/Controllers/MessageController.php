<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with([
            'conversations',
            'conversations.conversationParticipants' => function ($q) {
                $q->whereNot('user_id', Auth::id());
            },
            'conversations.messages',
            'conversations.messages.user'
        ])
            ->withCount('conversations')
            ->find(Auth::id());

        $conversations = $user->conversations;
        $conversationCount = $user->conversations_count;

        return view('messages.index')->with([
            'conversations' => $conversations,
            'conversations_count' => $conversationCount,
        ]);
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
        $validatedData = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
            'user_id' => 'required|integer|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create($validatedData);

        if ($message) {
            return response()->json([
                'message' => 'Message added successfully',
                'conversationId' => $message->conversation_id,
                'content' => $message,
            ]);
        } else {
            return response()->json([
                'message' => 'Message not added',
            ]);
        }
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
}
