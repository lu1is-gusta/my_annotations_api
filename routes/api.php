<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::resources([
        'users' => UserController::class,
        'notes' => NoteController::class
    ]);
});
