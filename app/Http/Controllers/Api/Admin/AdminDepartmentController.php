<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\Department\DepartmentItemResource;
use App\Http\Resources\Department\DepartmentCollectionResource;

class AdminDepartmentController extends Controller
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


    public function update(DepartmentRequest $request, string $id)
    {
        $department = Department::findOrFail($id);

        $state = $department->update($request->validated());

        return response()->json([
            'state' => $state
        ]);
    }
}
