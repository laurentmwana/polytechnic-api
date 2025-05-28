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
        $options = Option::query()->findPaginated();

        return OptionCollectionResource::collection($options);
    }


    public function show(string $id)
    {
        $option = Option::query()->findOneOrThrow($id);

        return new OptionItemResource($option);
    }
}
