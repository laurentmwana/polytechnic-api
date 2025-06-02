<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Option;
use App\Http\Controllers\Controller;
use App\Http\Resources\Option\OptionItemResource;
use App\Http\Resources\Option\OptionCollectionResource;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit');

        $builder = Option::with(['department', 'levels'])
            ->orderByDesc('updated_at');

        $options = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return OptionCollectionResource::collection($options);
    }


    public function show(string $id)
    {
        $option = Option::findOrFail($id);

        return new OptionItemResource($option);
    }
}
