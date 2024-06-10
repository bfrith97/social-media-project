<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\MyEvent;
use App\Models\Message;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\MessageService;
use App\Services\NewsService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private MessageService $messageService;
    private UserService $userService;

    public function __construct(MessageService $messageService, UserService $userService) {
        $this->messageService = $messageService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        $event = event(new MyEvent('this is a test'));

        return view('messages.index')->with([
            'user' => $user,
            'notificationsCount' => $notificationsCount,
            'conversations' => $conversations,
            'conversations_count' => $user->conversations_count,
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
        $message = $this->messageService->storeMessage($request);

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

    public function getUsersForNewChat(Request $request)
    {
        $users = User::whereNot('id', Auth::id())
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        foreach ($users as &$user) {
            $user['profile_picture'] = $user->profile_picture ? asset($user->profile_picture) : '';
            $user['subtitle'] = $user['followed_by_current_user'] ? 'Following' : $user['role'];
        }

        return response()->json([
            'users' => $users,
            'create_conversation_route' => route('conversations.store'),
            'csrfToken' => csrf_token(),
        ]);
    }
}
