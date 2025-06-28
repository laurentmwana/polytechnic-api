<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Resources\Actuality\ActualityCollectionResource;
use App\Http\Resources\Actuality\ActualityItemResource;
use App\Models\Actuality;
use App\Http\Controllers\Controller;
use App\Services\SearchData;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ActualityController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $order = $request->input('order', 'desc');

        if (!in_array($order, FILTER_ORDERS)) $order = 'desc';

        $builder = Actuality::with(['comments'])
            ->orderBy('updated_at', $order);



        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, SEARCH_FIELDS_ACTUALITY);
            });
        }

        $actualities = $builder->paginate();

        return ActualityCollectionResource::collection($actualities);
    }



    public function show(string $id)
    {
        $actuality = Actuality::with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->findOrFail($id);

        return new ActualityItemResource($actuality);
    }

}
