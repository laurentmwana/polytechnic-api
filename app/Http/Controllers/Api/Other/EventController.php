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
    private const SEARCH_FIELDS_EVENT = [
        'id',
        'title',
        'content',
        'description',
        'start_at',
        'created_at',
        'updated_at',
    ];

    private const SEARCH_FIELDS_YEAR = [
        'year_academic_id',
        'id',
        'name',
        'start',
        'end',
        'created_at',
        'updated_at',
    ];

    private const SEARCH_FIELDS_LEVEL = [
        'name',
        'id',
        'alias',
        'created_at',
        'updated_at',
    ];

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
                SearchData::handle($query, $search, self::SEARCH_FIELDS_EVENT);

                $query->orWhereHas('yearAcademic', function ($q) use ($search) {
                    SearchData::handle($q, $search, self::SEARCH_FIELDS_YEAR);
                })->orWhereHas('level', function ($q) use ($search) {
                    SearchData::handle($q, $search, self::SEARCH_FIELDS_LEVEL);
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
