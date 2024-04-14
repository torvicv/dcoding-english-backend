<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return [
            'user' => $request->user(),
            'token' => $request->bearerToken()
        ];
    });

    Route::post('/user/logout', [UserController::class, 'logout']);

});

Route::post('/user/login', [UserController::class, 'auth']);

Route::post('/user/register', [UserController::class,'store']);
