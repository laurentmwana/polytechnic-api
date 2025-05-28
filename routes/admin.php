<?php

use App\Http\Controllers\Api\Admin\AdminDepartmentController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->group(function () {
        Route::apiResource('department', AdminDepartmentController::class)
            ->parameter('department', 'id')
            ->except(['destroy', 'store']);
    });
