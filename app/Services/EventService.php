<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\Request;

class EventService
{
    public function getEventDates(): array
    {
        $eventDates  = EventDate::with('event', 'event.eventType', 'event.eventLocation')->get();

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
