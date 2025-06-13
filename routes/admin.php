<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminJuryController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AdminYearController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\AdminCourseController;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminStudentController;
use App\Http\Controllers\Api\Admin\AdminTeacherController;
use App\Http\Controllers\Api\Admin\AdminDepartmentController;
use App\Http\Controllers\Api\Admin\AdminDeliberationController;
use App\Http\Controllers\Api\Admin\AdminResultController;
use App\Http\Controllers\Api\Admin\AdminLevelController;

Route::prefix('admin')
    ->name('#')
    ->middleware(['auth', "admin"])
    ->group(function () {
        Route::apiResource('department', AdminDepartmentController::class)
            ->parameter('department', 'id')
            ->except(['destroy', 'store']);

        Route::apiResource('option', AdminOptionController::class)
            ->parameter('option', 'id');

        Route::get('/year-academic', [AdminYearController::class, 'index'])
            ->name('year.index');
        Route::get('/year-academic/{id}', [AdminYearController::class, 'show'])
            ->name('year.show');
        Route::post('/year-academic/{id}/closed', [AdminYearController::class, 'closed'])
            ->name('year.closed');

        Route::apiResource('user', AdminUserController::class)
            ->parameter('user', 'id');

            Route::apiResource('result', AdminResultController::class)
            ->parameter('result', 'id');
            
        Route::post('/user/{id}/lock', [AdminUserController::class, 'lock'])
            ->name('user.lock');

        Route::apiResource('deliberation', AdminDeliberationController::class)
            ->parameter('deliberation', 'id');

        Route::apiResource('course', AdminCourseController::class)
            ->parameter('course', 'id');

        Route::apiResource('teacher', AdminTeacherController::class)
            ->parameter('teacher', 'id');

        Route::apiResource('level', AdminLevelController::class)
            ->parameter('level', 'id');

        Route::apiResource('jury', AdminJuryController::class)
            ->parameter('jury', 'id');

        Route::apiResource('student', AdminStudentController::class)
            ->parameter('student', 'id');

        Route::post('student/create-with-excel', [AdminStudentController::class, 'excell'])
            ->name('student.excell');
    });

Route::name('#')
    ->middleware(['auth', "admin"])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
    });
