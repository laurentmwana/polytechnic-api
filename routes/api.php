<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\Other\LevelController;
use App\Http\Controllers\Api\Other\OptionController;
use App\Http\Controllers\Api\Other\DepartmentController;
use App\Http\Controllers\Api\Other\YearCurrentController;
use App\Http\Controllers\Api\Profile\ProfileEditController;
use App\Http\Controllers\Api\Profile\ProfilePasswordController;


ROute::name('^')->group(function () {

    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');

    Route::get('/options', [OptionController::class, 'index'])->name('option.index');
    Route::get('/option/{id}', [OptionController::class, 'show'])->name('option.show');

    Route::get('/year/current', YearCurrentController::class)->name('year.current');

    Route::get('/levels', [LevelController::class, 'index'])->name('level.index');
    Route::get('/level/{id}', [LevelController::class, 'show'])->name('level.show');


    Route::middleware('auth')->group(function () {

        Route::get('/me', MeController::class)->name('me');

        Route::post('/profile/edit', ProfileEditController::class)
            ->name('profile.edit');

        Route::post('/profile/change-password', ProfilePasswordController::class)
            ->name('profile.password');
    });
});
