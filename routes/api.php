<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WineController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wines', [WineController::class, 'index']);
    Route::get('/wines/{id}', [WineController::class, 'find']);
    Route::post('/wines', [WineController::class, 'store']);
    Route::put('/wines/{id}', [WineController::class, 'update']);
    Route::delete('/wines/{id}', [WineController::class, 'destroy']);
});
