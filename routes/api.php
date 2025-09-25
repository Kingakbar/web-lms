<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ForgotApiPasswordController;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::post('/forgot-password', [ForgotApiPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotApiPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', function (Request $request) {
        return response()->json($request->user());
    });
});
