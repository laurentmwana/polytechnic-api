<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Api\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'login'])
        ->name('login');

    Route::post('forgot-password', PasswordResetLinkController::class)
        ->name('password.email');

    Route::post('reset-password', NewPasswordController::class)
        ->name('password.store');

    Route::post('refresh', [AuthenticatedSessionController::class, 'refresh'])
        ->name('refresh');
});

Route::middleware('auth')->group(function () {
    Route::post('email/verify/{opt}', VerifyEmailController::class)
        ->middleware(['throttle:50,1'])
        ->name('verify.opt');

    Route::post('confirm-password', ConfirmablePasswordController::class);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
