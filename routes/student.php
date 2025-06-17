<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Student\FolderController;
use App\Http\Controllers\Api\Student\CourseFollowedController;
use App\Http\Controllers\Api\Student\ResultController;

Route::prefix('/student')
    ->name('°')
    ->middleware('auth')
    ->group(function () {
        

        Route::get('/course-followed', [CourseFollowedController::class, 'index'])
            ->name('followed.index');

        Route::post('/course-followed/{id}', [CourseFollowedController::class, 'follow'])
            ->name('followed.create');

        Route::get('/folder', FolderController::class)
            ->name('folder.index');

        Route::get('/result', [ResultController::class, 'index'])
            ->name('result.index');

        Route::get('/result/{id}/download', [ResultController::class, 'download'])
            ->name('result.download');
    });
