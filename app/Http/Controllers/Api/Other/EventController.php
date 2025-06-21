<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventItemResource;
use App\Http\Resources\Event\EventCollectionResource;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['level'])
            ->orderByDesc('updated_at')
            ->paginate();

        return EventCollectionResource::collection($events);
    }


    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return new EventItemResource($event);
    }
}
