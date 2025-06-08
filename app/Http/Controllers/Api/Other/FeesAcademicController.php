<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\FeesAcademic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Fees\FeesItemResource;
use App\Http\Resources\Fees\FeesCollectionResource;

class FeesAcademicController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit');

        $builder = FeesAcademic::with(['level', 'yearAcademic'])
            ->orderByDesc('updated_at');

        $feesAcademics = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return FeesCollectionResource::collection($feesAcademics);
    }


    public function show(string $id)
    {
        $fees = FeesAcademic::findOrFail($id);

        return new FeesItemResource($fees);
    }
}
