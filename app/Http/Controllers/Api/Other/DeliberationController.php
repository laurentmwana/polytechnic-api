<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Deliberation;
use App\Http\Controllers\Controller;
use App\Http\Resources\Deliberation\DeliberationCollectionResource;
use App\Http\Resources\Deliberation\DeliberationItemResource;
use Illuminate\Http\Request;

class DeliberationController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit');

        $builder = Deliberation::with(['level', 'yearAcademic'])
            ->orderByDesc('updated_at');

        $delibes = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return DeliberationCollectionResource::collection($delibes);
    }


    public function show(string $id)
    {
        $delibe = Deliberation::findOrFail($id);

        return new DeliberationItemResource($delibe);
    }
}
