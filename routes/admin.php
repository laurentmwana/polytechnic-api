<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminDepartmentController;


Route::prefix('admin')
    ->group(function () {
        Route::apiResource('department', AdminDepartmentController::class)
            ->parameter('department', 'id')
            ->except(['destroy', 'store']);

        Route::apiResource('option', AdminOptionController::class)
            ->parameter('option', 'id')
            ->except(['destroy', 'store']);
    });
