<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\TeacherItemResource;
use App\Http\Resources\Teacher\TeacherCollectionResource;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit');

        $builder = Teacher::with(['department', 'courses'])
            ->orderByDesc('updated_at');

        $teachers = $limit > 0 ? $builder->limit($limit)->get() : $builder->paginate();

        return TeacherCollectionResource::collection($teachers);
    }


    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        return new TeacherItemResource($teacher);
    }
}
