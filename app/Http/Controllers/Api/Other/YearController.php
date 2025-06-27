<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\YearAcademic;
use App\Http\Controllers\Controller;
use App\Http\Resources\Year\YearItemResource;
use App\Http\Resources\Year\YearCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class YearController extends Controller
{

    public function index(Request $request)
    {

        $orderClosed = $request->query->get('closed', 'asc');

        if (!in_array($orderClosed, FILTER_ORDERS)) $orderClosed = 'asc';

        $builder = YearAcademic::orderByDesc($orderClosed);

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



    public function current()
    {
        $year = YearAcademic::where('is_closed', '=', false)->first();

        if (! ($year instanceof YearAcademic)) {
            return response()->json(['data' => null]);
        }

        return new YearItemResource($year);
    }
}
