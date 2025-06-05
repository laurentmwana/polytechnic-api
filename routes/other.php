<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SelectDataController;

Route::prefix('/data-select')
    ->name('&')
    ->group(function () {
        Route::get('/students', [SelectDataController::class, 'students'])
            ->name('student');

        Route::get('/levels', [SelectDataController::class, 'levels'])
            ->name('level');

        Route::get('/year-academic', [SelectDataController::class, 'years'])
            ->name('years');


        Route::get('/departments', [SelectDataController::class, 'departments'])
            ->name('departments');
            
        Route::get('/teachers', [SelectDataController::class, 'teachers'])
            ->name('teachers');
    });
