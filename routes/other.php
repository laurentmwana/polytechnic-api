<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SelectDataController;

Route::prefix('/data-select')
->name('&')
->group(function () {
    Route::get('/students', [SelectDataController::class, 'students'])
        ->name('student');
});