<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Option;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Http\Resources\Option\OptionItemResource;
use App\Http\Resources\Option\OptionActionResource;
use App\Http\Resources\Option\OptionCollectionResource;

class AdminOptionController extends Controller
{

    public function index()
    {
        $options = Option::query()->findPaginated();

        return OptionCollectionResource::collection($options);
    }

    public function store(OptionRequest $request)
    {
        $option = Option::create($request->validated());

        return new OptionActionResource($option);
    }

    public function show(string $id)
    {
        $option = Option::query()->findOneOrThrow($id);

        return new OptionItemResource($option);
    }


    public function update(OptionRequest $request, string $id)
    {
        $option = Option::findOrFail($id);

        $state = $option->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $option = Option::findOrFail($id);

        $state = $option->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
