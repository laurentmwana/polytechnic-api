<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\Other\YearController;
use App\Http\Controllers\Api\Other\LevelController;
use App\Http\Controllers\Api\Other\OptionController;
use App\Http\Controllers\Api\Other\ContactController;
use App\Http\Controllers\Api\Other\TeacherController;
use App\Http\Controllers\Api\Other\DepartmentController;
use App\Http\Controllers\Api\Other\DeliberationController;
use App\Http\Controllers\Api\Profile\ProfileEditController;
use App\Http\Controllers\Api\Profile\ProfilePasswordController;


Route::name('^')->group(function () {

    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');

    Route::get('/options', [OptionController::class, 'index'])->name('option.index');
    Route::get('/option/{id}', [OptionController::class, 'show'])->name('option.show');

    Route::get('/current/year', [YearController::class, 'current'])->name('year.current');
    Route::get('/years', [YearController::class, 'index'])->name('year.index');
    Route::get('/year/{id}', [YearController::class, 'show'])->name('year.show');

    Route::get('/levels', [LevelController::class, 'index'])->name('level.index');
    Route::get('/level/{id}', [LevelController::class, 'show'])->name('level.show');


    Route::get('/deliberations', [DeliberationController::class, 'index'])
        ->name('delibe.index');
    Route::get('/deliberation/{id}', [DeliberationController::class, 'show'])
        ->name('delibe.show');


    Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teacher/{id}', [TeacherController::class, 'show'])->name('teacher.show');

    Route::post('/contact', ContactController::class)->name('contact.send');


    Route::middleware('auth')->group(function () {

        Route::get('/me', MeController::class)->name('me');

        Route::post('/profile/edit', ProfileEditController::class)
            ->name('profile.edit');

        Route::post('/profile/change-password', ProfilePasswordController::class)
            ->name('profile.password');
    });
});
