<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;

class YearCurrentController extends Controller
{
    public function __invoke()
    {
        $year = YearAcademic::where('is_closed', '=', false)->first();

        if (! ($year instanceof YearAcademic)) {
            return response()->json(['data' => null]);
        }

        return new YearItemResource($year);
    }
}
