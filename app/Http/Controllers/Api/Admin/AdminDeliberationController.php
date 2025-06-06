<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Support\Str;
use App\Models\Deliberation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliberationRequest;
use App\Http\Resources\Deliberation\DeliberationItemResource;
use App\Http\Resources\Deliberation\DeliberationCollectionResource;

class AdminDeliberationController extends Controller
{
    public function index()
    {
        $deliberations = Deliberation::with(['level', 'yearAcademic'])
            ->orderByDesc('updated_at')
            ->paginate();

        return DeliberationCollectionResource::collection($deliberations);
    }


    public function store(DeliberationRequest $request)
    {
        $deliberation = Deliberation::create([
            ...$request->validated(),
            'criteria' => Str::markdown($request->validated('criteria')),
        ]);

        return response()->json([
            'state' => $deliberation !== null,
        ]);
    }

    public function show(string $id)
    {
        $deliberation = Deliberation::findOrFail($id);

        return new DeliberationItemResource($deliberation);
    }

    public function update(DeliberationRequest $request, string $id)
    {
        $deliberation = Deliberation::findOrFail($id);

        $state = $deliberation->update([
            ...$request->validated(),
            'criteria' => Str::markdown($request->validated('criteria')),
        ]);

        return response()->json([
            'state' => $state
        ]);
    }


    public function destroy(string $id)
    {
        $deliberation = Deliberation::findOrFail($id);

        $state = $deliberation->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
