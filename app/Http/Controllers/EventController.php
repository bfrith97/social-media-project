<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventDates  = EventDate::with('event', 'event.eventType', 'event.eventLocation')->get();

        $eventDatesOnline = $eventDates->filter(function ($eventDate) {
            return $eventDate->event->event_location_id == 1;
        });

        return view('events.index')->with([
            'eventDates' => $eventDates,
            'eventDatesOnline' => $eventDatesOnline,
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
        $event = Event::find($id);
        return view('events.show')->with([
            'event' => $event
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
