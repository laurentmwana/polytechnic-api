<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Jury;
use App\Http\Controllers\Controller;
use App\Http\Requests\JuryRequest;
use App\Http\Resources\Jury\JuryItemResource;
use App\Http\Resources\Jury\JuryActionResource;
use App\Http\Resources\Jury\JuryCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminJuryController extends Controller
{

    public function index(Request $request)
    {
        $builder = Jury::with(['deliberation', 'teacher'])
            ->orderByDesc('updated_at');

        $search = $request->query->get('search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_EVENT);

                $query->orWhereHas('deliberation', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_DELIBE);
                })->orWhereHas('teacher', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_TEACHER);
                });
            });
        }

        $juries = $builder->paginate();

        return JuryCollectionResource::collection($juries);
    }

    public function store(JuryRequest $request)
    {
        $jury = Jury::create($request->validated());

        return response()->json([
            'state' => $jury !== null
        ]);
    }

    public function show(string $id)
    {
        $jury = Jury::findOrFail($id);

        return new JuryItemResource($jury);
    }


    public function update(JuryRequest $request, string $id)
    {
        $jury = Jury::findOrFail($id);

        $state = $jury->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $jury = Jury::findOrFail($id);

        $state = $jury->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
