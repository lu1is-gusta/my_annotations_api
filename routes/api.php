<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::resources([
        'user' => UserController::class,
        'note' => NoteController::class
    ]);
});
