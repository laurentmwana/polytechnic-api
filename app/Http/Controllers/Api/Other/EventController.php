<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventItemResource;
use App\Http\Resources\Event\EventCollectionResource;
use App\Services\SearchData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $builder = Event::with(['level', 'yearAcademic']);

        $builder = $builder->orderByDesc('updated_at');

        $lastEvent = $builder
            ->where('start_at', '>', now())
            ->orderByDesc('updated_at')
            ->first();

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
