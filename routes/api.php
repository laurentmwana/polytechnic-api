<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\Other\LevelController;
use App\Http\Controllers\Api\Other\OptionController;
use App\Http\Controllers\Api\Other\DepartmentController;
use App\Http\Controllers\Api\Other\YearCurrentController;
use App\Http\Controllers\Api\Profile\ProfileEditController;
use App\Http\Controllers\Api\Profile\ProfilePasswordController;

Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/department/{id}', [DepartmentController::class, 'show']);

Route::get('/options', [OptionController::class, 'index']);
Route::get('/option/{id}', [OptionController::class, 'show']);

Route::get('/year/current', YearCurrentController::class);

Route::get('/levels', [LevelController::class, 'index']);
Route::get('/level/{id}', [LevelController::class, 'show']);


Route::middleware('auth')->group(function () {

    Route::get('/me', MeController::class);

    Route::post('/profile/edit', ProfileEditController::class)
        ->name('profile.edit');

    Route::post('/profile/change-password', ProfilePasswordController::class)
        ->name('profile.password');
});
