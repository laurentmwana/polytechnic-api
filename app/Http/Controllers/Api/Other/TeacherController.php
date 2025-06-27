<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\TeacherItemResource;
use App\Http\Resources\Teacher\TeacherCollectionResource;
use App\Services\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private const SEARCH_FIELDS_TEACHER = [
        'name',
        'id',
        'firstname',
        'gender',
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
        $search = $request->query->get('search');
        $limit = $request->query->getInt('limit');

        $builder = Teacher::with(['department', 'courses'])
            ->orderByDesc('updated_at');

        if (!empty($search)) {
            $builder->where(function (Builder $query) use ($search) {
                SearchData::handle($query, $search, self::SEARCH_FIELDS_TEACHER);
                 $query->orWhereHas('yearAcademic', function ($q) use ($search) {
                    SearchData::handle($q, $search, self::SEARCH_FIELDS_DEPARTMENT);
                });
            });
        }

        $teachers = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return TeacherCollectionResource::collection($teachers);
    }


    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        return new TeacherItemResource($teacher);
    }
}
