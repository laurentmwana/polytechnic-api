<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\FeesLaboratory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Fees\FeesItemResource;
use App\Http\Resources\Fees\FeesCollectionResource;

class FeesLaboratoryController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit');

        $builder = FeesLaboratory::with(['level', 'yearAcademic'])
            ->orderByDesc('updated_at');

        $feesLaboratories = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return FeesCollectionResource::collection($feesLaboratories);
    }


    public function show(string $id)
    {
        $fees = FeesLaboratory::findOrFail($id);

        return new FeesItemResource($fees);
    }
}
