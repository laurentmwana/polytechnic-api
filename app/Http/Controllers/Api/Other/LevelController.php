<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Http\Resources\Level\LevelItemResource;
use App\Http\Resources\Level\LevelCollectionResource;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with(['option', 'yearAcademic'])
            ->orderByDesc('updated_at')
            ->paginate();

        return LevelCollectionResource::collection($levels);
    }


    public function show(string $id)
    {
        $level = Level::findOrFail($id);

        return new LevelItemResource($level);
    }
}
