<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;

class YearCurrentController extends Controller
{
    public function __invoke()
    {
        $year = YearAcademic::where('is_closed', '=', true)->first();

        return new YearItemResource($year);
    }
}
