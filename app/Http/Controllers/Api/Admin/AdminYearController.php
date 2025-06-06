<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;
use App\Http\Resources\Year\YearCollectionResource;

class AdminYearController extends Controller
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

    public function closed(string $id)
    {
        $year = YearAcademic::findOrFail($id);

        $newYear = $this->getNewYear($year);


        return new YearItemResource($newYear);
    }

    private function getNewYear(YearAcademic $year): YearAcademic
    {
        $year->update(['is_closed' => true]);

        $start = $year->end;
        $end = $year->end  + 1;

        return YearAcademic::create([
            'start' => $end,
            'end' => $end,
            "name" => "{$start}-{$end}"
        ]);
    }
}
