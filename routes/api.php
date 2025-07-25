<?php

use App\Http\Controllers\Api\Other\ActualityCommentController;
use App\Http\Controllers\Api\Other\ActualityController;
use App\Http\Controllers\Api\Other\ActualityLikeController;
use App\Http\Controllers\Api\Other\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\Other\YearController;
use App\Http\Controllers\Api\Other\LevelController;
use App\Http\Controllers\Api\Other\CourseController;
use App\Http\Controllers\Api\Other\TeacherController;
use App\Http\Controllers\Api\Other\EventController;
use App\Http\Controllers\Api\Other\DepartmentController;
use App\Http\Controllers\Api\Other\DeliberationController;
use App\Http\Controllers\Api\Profile\ProfileEditController;
use App\Http\Controllers\Api\Profile\ProfilePasswordController;

Route::name('^')->group(function () {

    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');

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

    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');

    Route::get('/actualities', [ActualityController::class, 'index'])->name('actuality.index');
    Route::get('/actuality/{id}', [ActualityController::class, 'show'])->name('actuality.show');
    Route::post('/actuality/{id}/comment', [ActualityCommentController::class, 'store'])->name('actuality.comment');

    Route::get('/events', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

    Route::get('/notification/{id}', [NotificationController::class, 'show']);
    Route::put('/mark-as-read/notification', [NotificationController::class, 'markAsRead']);
    Route::delete('/notification/{id}/destroy', [NotificationController::class, 'destroy']);
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/last-notification', [NotificationController::class, 'lastNotification']);

    Route::middleware('auth')->group(function () {


        Route::get('/me', MeController::class)->name('me');

        Route::post('/profile/edit', ProfileEditController::class)
            ->name('profile.edit');

        Route::post('/profile/change-password', ProfilePasswordController::class)
            ->name('profile.password');
    });
});
