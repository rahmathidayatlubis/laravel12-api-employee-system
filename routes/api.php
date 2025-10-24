<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniAuthController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});


Route::prefix('alumni')->group(function () {
    Route::post('/login', [AlumniAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AlumniAuthController::class, 'profile']);
        Route::put('/profile', [AlumniAuthController::class, 'updateProfile']);
        Route::post('/change-password', [AlumniAuthController::class, 'changePassword']);
        Route::post('/logout', [AlumniAuthController::class, 'logout']);
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('alumni', AlumniController::class);

    Route::get('/alumni-statistics', [AlumniController::class, 'statistics']);
});
