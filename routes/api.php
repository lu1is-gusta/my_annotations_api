<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;

Route::prefix('v1')->group(function () {
    Route::post('users/register', [UserController::class, 'register'])->middleware('throttle:6,1');
    Route::post('users/login', [UserController::class, 'login'])->middleware('throttle:6,1');

    // Routes with authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::delete('users/logout', [UserController::class, 'logout']);

        Route::apiResource('users', UserController::class)->only(['show', 'update', 'destroy']);
        Route::apiResource('notes', NoteController::class);
    });
});
