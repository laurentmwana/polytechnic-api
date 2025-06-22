<?php

namespace App\Http\Controllers\Api\Admin;

use App\Jobs\NewEventJob;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\Event\EventItemResource;
use App\Http\Resources\Event\EventCollectionResource;
use Illuminate\Support\Str;

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
        $event = Event::create([
            ...$request->validated(),
            'content' => Str::markdown($request->validated('content'))
        ]);

        NewEventJob::dispatch($event);

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

        $state = $event->update([
            ...$request->validated(),
            'content' => Str::markdown($request->validated('content'))
        ]);

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
