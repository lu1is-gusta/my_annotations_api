<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Middleware\BasicAuth;

Route::middleware([BasicAuth::class])->prefix('v1')->group(function () { 
    Route::post('users/register', [UserController::class, 'register']); //ajustar o retorno quando acontece erro de validação
    Route::post('users/login', [UserController::class, 'login']);
    Route::get('users/logout', [UserController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resources([
            'users' => UserController::class,
            'notes' => NoteController::class
        ]);
    });
});
