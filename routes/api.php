<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Other\DepartmentController;


Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/department/{id}', [DepartmentController::class, 'show']);
