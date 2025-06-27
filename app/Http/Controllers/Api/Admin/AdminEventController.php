<?php

namespace App\Http\Controllers\Api\Admin;

use App\Jobs\NewEventJob;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\Event\EventItemResource;
use App\Http\Resources\Event\EventCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $builder = Event::with(['level'])
            ->orderByDesc('updated_at');

        $search = $request->query->get('search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_EVENT);

                $query->orWhereHas('yearAcademic', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_YEAR);
                })->orWhereHas('level', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_LEVEL);
                });
            });
        }

        $events = $builder->paginate();

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
