<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Deliberation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliberationRequest;
use App\Http\Resources\Deliberation\DeliberationItemResource;
use App\Http\Resources\Deliberation\DeliberationCollectionResource;

class AdminDeliberationController extends Controller
{
    public function index(Request $request)
    {
        $builder = Deliberation::with(['level', 'yearAcademic'])
            ->orderByDesc('updated_at');

        $semester = $request->query->get('semester');
        $search = $request->query->get('earch$search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_DELIBE);
                $query->orWhereHas('yearAcademic', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_YEAR);
                })->orWhereHas('level', function ($q) use ($search) {
                    SearchData::handle($q, $search, SEARCH_FIELDS_LEVEL);
                });
            });
        }

        if (!empty($semester) && isset(QUERY_SEMESTERS[$semester])) {
            $semesterValue = QUERY_SEMESTERS[$semester];
            $builder->where('semester', $semesterValue);
        }

        $deliberations = $builder->paginate();

        return DeliberationCollectionResource::collection($deliberations);
    }


    public function store(DeliberationRequest $request)
    {
        $deliberation = Deliberation::create($request->validated());

        return response()->json([
            'state' => $deliberation !== null,
        ]);
    }

    public function show(string $id)
    {
        $deliberation = Deliberation::findOrFail($id);

        return new DeliberationItemResource($deliberation);
    }

    public function update(DeliberationRequest $request, string $id)
    {
        $deliberation = Deliberation::findOrFail($id);
        $state = $deliberation->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }


    public function destroy(string $id)
    {
        $deliberation = Deliberation::findOrFail($id);

        $state = $deliberation->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
