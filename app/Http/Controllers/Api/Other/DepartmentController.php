<?php

namespace App\Http\Controllers\Api\Other;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\Department\DepartmentItemResource;
use App\Http\Resources\Department\DepartmentCollectionResource;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::query()->findPaginated();

        return DepartmentCollectionResource::collection($departments);
    }


    public function show(string $id)
    {
        $department = Department::query()->findOneOrThrow($id);

        return new DepartmentItemResource($department);
    }
}
