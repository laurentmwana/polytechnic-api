<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Actuality\ActualityItemResource;
use App\Jobs\NewActualityJob;
use App\Models\Actuality;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActualityRequest;
use App\Http\Resources\Actuality\ActualityCollectionResource;
use App\Services\SearchData;
use Illuminate\Http\Request;

class AdminActualityController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->query->get('search');

        $builder = Actuality::with(['comments'])
            ->orderBy('updated_at' , 'desc');

        if ($search && !empty($search)) {
           SearchData::handle($builder, $search, SEARCH_FIELDS_ACTUALITY);
        }

        $actualities = $builder->paginate();

        return ActualityCollectionResource::collection($actualities);
    }

    public function store(ActualityRequest $request)
    {
        $user = $request->user();

        $actuality = Actuality::create($request->validated());

        if ($actuality instanceof Actuality) {
            NewActualityJob::dispatch($actuality, $user);
        }

        return response()->json([
            'state' => $actuality !== null,
        ]);
    }

    public function show(string $id)
    {
        $actuality = Actuality::findOrFail($id);

        return new ActualityItemResource($actuality);
    }

    public function update(ActualityRequest $request, string $id)
    {
        $actuality = Actuality::findOrFail($id);

        $state = $actuality->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }

    public function destroy(string $id)
    {
        $actuality = Actuality::findOrFail($id);

        $state = $actuality->delete();

        return response()->json([
            'state' => $state
        ]);
    }
}
