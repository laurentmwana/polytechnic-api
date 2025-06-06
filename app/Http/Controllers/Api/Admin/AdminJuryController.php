<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Jury;
use App\Http\Controllers\Controller;
use App\Http\Requests\JuryRequest;
use App\Http\Resources\Jury\JuryItemResource;
use App\Http\Resources\Jury\JuryActionResource;
use App\Http\Resources\Jury\JuryCollectionResource;

class AdminJuryController extends Controller
{

    public function index()
    {
        $juries = Jury::with(['deliberation', 'teacher'])->orderByDesc('updated_at')
            ->paginate();

        return JuryCollectionResource::collection($juries);
    }

    public function store(JuryRequest $request)
    {
        $jury = Jury::create($request->validated());

        return new JuryActionResource($jury);
    }

    public function show(string $id)
    {
        $jury = Jury::findOrFail($id);

        return new JuryItemResource($jury);
    }


    public function update(JuryRequest $request, string $id)
    {
        $jury = Jury::findOrFail($id);

        $state = $jury->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $jury = Jury::findOrFail($id);

        $state = $jury->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
