<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private NotificationService $notificationService;
    private UserService $userService;

    public function __construct(NotificationService $notificationService, UserService $userService) {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        return view('notifications.index')->with([
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations
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
        //
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

    public function markAllRead(): ?JsonResponse
    {
        $this->notificationService->markAllNotificationsAsRead();

        return response()->json([
            'message' => 'Notifications have been marked as read'
        ]);
    }
}
