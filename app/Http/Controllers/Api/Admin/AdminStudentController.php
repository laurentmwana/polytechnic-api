<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;
use App\Http\Resources\Year\YearCollectionResource;

class AdminYearController extends Controller
{

    public function index()
    {
        $years = Student::orderByDesc('updated_at')
            ->paginate();

        return YearCollectionResource::collection($years);
    }

    public function show(string $id)
    {
        $year = Student::findOrFail($id);

        return new YearItemResource($year);
    }

    public function closed(string $id)
    {
        $year = Student::findOrFail($id);

        $newYear = $this->getNewYear($year);

        return new YearItemResource($newYear);
    }
}
