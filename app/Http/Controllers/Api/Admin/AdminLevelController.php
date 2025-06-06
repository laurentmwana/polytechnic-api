<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Http\Requests\LevelRequest;
use App\Http\Resources\Level\LevelItemResource;
use App\Http\Resources\Level\LevelActionResource;
use App\Http\Resources\Level\LevelCollectionResource;

class AdminLevelController extends Controller
{

    public function index()
    {
        $levels = Level::with(['option', 'yearAcademic'])->orderByDesc('updated_at')
            ->paginate();

        return LevelCollectionResource::collection($levels);
    }

    public function store(LevelRequest $request)
    {
        $level = Level::create($request->validated());

        return new LevelActionResource($level);
    }

    public function show(string $id)
    {
        $level = Level::findOrFail($id);

        return new LevelItemResource($level);
    }


    public function update(LevelRequest $request, string $id)
    {
        $level = Level::findOrFail($id);

        $state = $level->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $level = Level::findOrFail($id);

        $state = $level->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
