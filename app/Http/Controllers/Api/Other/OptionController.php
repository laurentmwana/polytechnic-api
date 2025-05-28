<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Option;
use App\Http\Controllers\Controller;
use App\Http\Resources\Option\OptionItemResource;
use App\Http\Resources\Option\OptionCollectionResource;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::with(['department'])
            ->orderByDesc('updated_at')
            ->paginate();

        return OptionCollectionResource::collection($options);
    }


    public function show(string $id)
    {
        $option = Option::findOrFail($id);

        return new OptionItemResource($option);
    }
}
