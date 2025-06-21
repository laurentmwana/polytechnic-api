<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\Event\EventItemResource;
use App\Http\Resources\Event\EventCollectionResource;
class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::with(['level'])
            ->orderByDesc('updated_at')
            ->paginate();

        return EventCollectionResource::collection($events);
    }

    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());

        return response()->json([
            'state' => $event instanceof Event
        ]);
    }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return new EventItemResource($event);
    }


    public function update(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        $state = $event->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        $state = $event->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
