<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;
use App\Http\Resources\Year\YearCollectionResource;

class YearController extends Controller
{
    public function index()
    {
        $years = YearAcademic::orderBy('is_closed')
            ->paginate();

        return YearCollectionResource::collection($years);
    }


    public function show(string $id)
    {
        $year = YearAcademic::findOrFail($id);

        return new YearItemResource($year);
    }



    public function current()
    {
        $year = YearAcademic::where('is_closed', '=', false)->first();

        if (! ($year instanceof YearAcademic)) {
            return response()->json(['data' => null]);
        }

        return new YearItemResource($year);
    }
}
