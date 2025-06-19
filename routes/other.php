<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

Route::prefix('/data-select')
    ->name('&')
    ->group(function () {
        Route::get('/students', [DataController::class, 'students'])
            ->name('student');

        Route::get('/levels', [DataController::class, 'levels'])
            ->name('level');

        Route::get('/year-academic', [DataController::class, 'years'])
            ->name('years');

        Route::get('/departments', [DataController::class, 'departments'])
            ->name('departments');

        Route::get('/teachers', [DataController::class, 'teachers'])
            ->name('teachers');

        Route::get('/options', [DataController::class, 'options'])
            ->name('options');

        Route::get('/deliberations', [DataController::class, 'delibes'])
            ->name('delibe');
    });
