<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;
use App\Http\Resources\Year\YearCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminYearController extends Controller
{
    public function index(Request $request)
    {
        $orderClosed = $request->query->get('closed', 'asc');

        if (!in_array($orderClosed, FILTER_ORDERS)) $orderClosed = 'asc';

        $builder = YearAcademic::orderBy('is_closed', $orderClosed);

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_YEAR);
            });
        }

        $years = $builder->paginate();

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

        $newYear = $this->createNewYear($year);

        return response()->json([
            'state' => $newYear instanceof YearAcademic,
        ]);
    }

    private function createNewYear(YearAcademic $year): YearAcademic
    {
        [$nameYear, $start, $end] = $this->getYearName($year);

        $existingYear = YearAcademic::where('name', $nameYear)->first();

        if ($existingYear) {
            throw new \Exception("L'année académique $nameYear existe déjà.");
        }

        $newYear =  YearAcademic::create([
            'start' => $start,
            'end'   => $end,
            'name'  => $nameYear,
        ]);

        $year->update(['is_closed' => true]);

        return $newYear;
    }

    private function getYearName(YearAcademic $year): array
    {
        $start = $year->end;
        $end = $year->end + 1;

        return [
            "{$start}-{$end}",
            $start,
            $end,
        ];
    }
}
