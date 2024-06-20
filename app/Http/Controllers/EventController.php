<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDate;
use App\Services\EventService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    private EventService $eventService;
    private UserService $userService;


    public function __construct(EventService $eventService, UserService $userService) {
        $this->eventService = $eventService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        [$eventDates, $eventDatesOnline] = $this->eventService->getEventDates();

        return view('events.index')->with([
            'eventDates' => $eventDates,
            'eventDatesOnline' => $eventDatesOnline,
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
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $event = $this->eventService->getEvent($id);

        return view('events.show')->with([
            'event' => $event,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations
        ]);
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
