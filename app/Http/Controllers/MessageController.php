<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    private MessageService $messageService;
    private UserService $userService;

    public function __construct(MessageService $messageService, UserService $userService)
    {
        $this->messageService = $messageService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

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
    public function store(MessageRequest $request): ?JsonResponse
    {
        try {
            $message = $this->messageService->storeMessage($request);

            return response()->json([
                'message' => 'Message added successfully',
                'conversationId' => $message->conversation_id,
                'content' => $message,
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
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

    public function getUsersForNewChat(Request $request): JsonResponse
    {
        $users = $this->messageService->getUsersForNewChat($request);

        return response()->json([
            'users' => $users,
            'create_conversation_route' => route('conversations.store'),
            'csrfToken' => csrf_token(),
        ]);
    }
}
