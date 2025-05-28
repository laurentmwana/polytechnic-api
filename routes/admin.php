<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminYearController;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminDepartmentController;

Route::prefix('admin')
    ->group(function () {
        Route::apiResource('department', AdminDepartmentController::class)
            ->parameter('department', 'id')
            ->except(['destroy', 'store']);

        Route::apiResource('option', AdminOptionController::class)
            ->parameter('option', 'id');

        Route::get('/year', [AdminYearController::class, 'index']);
        Route::get('/year/{id}', [AdminYearController::class, 'show']);
        Route::post('/year/{id}/closed', [AdminYearController::class, 'closed']);


        Route::apiResource('option', AdminOptionController::class)
            ->parameter('option', 'id');
    });
