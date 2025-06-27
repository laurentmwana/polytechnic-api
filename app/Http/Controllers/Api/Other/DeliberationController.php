<?php

namespace App\Http\Controllers\Api\Other;

use App\Enums\SemesterEnum;
use App\Models\Deliberation;
use App\Http\Controllers\Controller;
use App\Http\Resources\Deliberation\DeliberationCollectionResource;
use App\Http\Resources\Deliberation\DeliberationItemResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeliberationController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit', 0);

        $builder = Deliberation::with(['level', 'yearAcademic'])->orderByDesc('updated_at');

        if ($limit > 0) {
            return DeliberationCollectionResource::collection($builder->take($limit)->get());
        }

        $search = $request->query->get('search');
        $semester = $request->query->get('semester');

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

        if (!empty($semester)) {
            if (!isset($semesters[$semester])) {
                return response()->json([
                    'message' => "Semestre invalide: $semester"
                ], 400); // Code HTTP 400 pour erreur client
            }

            $semesterValue = QUERY_SEMESTERS[$semester];
            $builder->where('semester', $semesterValue);
        }

        return DeliberationCollectionResource::collection($builder->paginate());
    }

    public function show(string $id)
    {
        $delibe = Deliberation::with(['level', 'yearAcademic'])->findOrFail($id);
        return new DeliberationItemResource($delibe);
    }
}
