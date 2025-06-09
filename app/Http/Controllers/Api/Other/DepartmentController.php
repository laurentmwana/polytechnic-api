<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\Department\DepartmentItemResource;
use App\Http\Resources\Department\DepartmentCollectionResource;
use App\Http\Controllers\Api\Student\CourseFollowedController;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['options'])
            ->orderByDesc('updated_at')
            ->paginate();

        return DepartmentCollectionResource::collection($departments);
    }


    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return new DepartmentItemResource($department);
    }
}
