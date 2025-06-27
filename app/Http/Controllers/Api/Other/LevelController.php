<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Http\Resources\Level\LevelItemResource;
use App\Http\Resources\Level\LevelCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    private const SEARCH_FIELDS_LEVEL = [
        'name',
        'id',
        'alias',
        'created_at',
        'updated_at',
    ];

    private const SEARCH_FIELDS_DEPARTMENT = [
        'name',
        'id',
        'alias',
        'created_at',
        'updated_at',
    ];

    public function index(Request $request)
    {
        $builder = Level::with(['department'])
            ->orderByDesc('updated_at');

        $search = $request->query->get('search');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, self::SEARCH_FIELDS_LEVEL);
                 $query->orWhereHas('yearAcademic', function ($q) use ($search) {
                    SearchData::handle($q, $search, self::SEARCH_FIELDS_DEPARTMENT);
                });
            });
        }

        $levels = $builder->paginate();

        return LevelCollectionResource::collection($levels);
    }


    public function show(string $id)
    {
        $level = Level::findOrFail($id);

        return new LevelItemResource($level);
    }
}
