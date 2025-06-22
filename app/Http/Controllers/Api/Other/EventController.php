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
        $builder = Event::with(['level', 'yearAcademic']);

        $events = $builder->orderByDesc('updated_at')->paginate();

        $lastEvent = $builder
            ->where('start_at', '>', now())
            ->orderByDesc('updated_at')
            ->first();

        return EventCollectionResource::collection($events)
            ->additional([
                'lastEvent' => $lastEvent
            ]);
    }


    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return new EventItemResource($event);
    }
}
