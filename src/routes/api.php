<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except('show');
    Route::post('/logout', [AuthController::class, 'logout']);
});
