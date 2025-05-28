<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Other\OptionController;
use App\Http\Controllers\Api\Other\DepartmentController;

Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/department/{id}', [DepartmentController::class, 'show']);

Route::get('/options', [OptionController::class, 'index']);
Route::get('/option/{id}', [OptionController::class, 'show']);
