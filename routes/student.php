<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Student\PaidAcademicController;
use App\Http\Controllers\Api\Student\CourseFollowedController;
use App\Http\Controllers\Api\Student\PaidLaboratoryController;

Route::prefix('/student')
    ->name('°')
    ->middleware('auth')
    ->group(function () {
        Route::get('/paid-academic', [PaidAcademicController::class, 'index'])
            ->name('aca.index');

        Route::get('/paid-academic/{id}', [PaidAcademicController::class, 'show'])
            ->name('aca.show');

        Route::get('/paid-laboratory', [PaidLaboratoryController::class, 'index'])
            ->name('labo.index');
        Route::get('/paid-laboratory/{id}', [PaidLaboratoryController::class, 'show'])
            ->name('labo.show');

        Route::get('/course-followed', [CourseFollowedController::class, 'index'])
            ->name('followed.index');

        Route::post('/course-followed/{id}', [CourseFollowedController::class, 'follow'])
            ->name('followed.create');
    });
