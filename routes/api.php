<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;

Route::prefix('v1')->group(function () { 
    Route::post('users/register', [UserController::class, 'register']); //ajustar o retorno quando acontece erro de validação
    Route::post('users/login', [UserController::class, 'login']);
    
    //Routes with authentications
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('users/logout', [UserController::class, 'logout']);

        Route::resources([
            'users' => UserController::class,
            'notes' => NoteController::class
        ]);

        
    });
});