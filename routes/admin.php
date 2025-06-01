<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AdminYearController;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminDepartmentController;


Route::prefix('admin')
    ->name('#')
    ->middleware(['auth', "admin"])
    ->group(function () {
        Route::apiResource('department', AdminDepartmentController::class)
            ->parameter('department', 'id')
            ->except(['destroy', 'store']);

        Route::apiResource('option', AdminOptionController::class)
            ->parameter('option', 'id');

        Route::get('/year', [AdminYearController::class, 'index'])
            ->name('year.index');
        Route::get('/year/{id}', [AdminYearController::class, 'show'])
            ->name('year.show');
        Route::post('/year/{id}/closed', [AdminYearController::class, 'closed'])
            ->name('year.closed');

        Route::apiResource('user', AdminUserController::class)
            ->parameter('user', 'id');
                Route::post('/user/{id}/lock', [AdminUserController::class, 'lock'])
            ->name('user.lock');
    });
