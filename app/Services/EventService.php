<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventDate;

class EventService extends ParentService
{
    public function getEventDates(): array
    {
        $eventDates = EventDate::with('event', 'event.eventType', 'event.eventLocation')
            ->get();

        $eventDatesOnline = $eventDates->filter(function ($eventDate) {
            return $eventDate->event->event_location_id == 1;
        });

        return [$eventDates, $eventDatesOnline];
    }

    public function getEvent($id): array
    {
        return Event::find($id);
    }
}
