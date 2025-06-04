<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WineController;

// Auth routes
Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('guest')->post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Wine routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wines', [WineController::class, 'index']);
    Route::get('/wines/{id}', [WineController::class, 'find']);
    Route::post('/wines', [WineController::class, 'store']);
    Route::put('/wines/{id}', [WineController::class, 'update']);
    Route::delete('/wines/{id}', [WineController::class, 'destroy']);
});

