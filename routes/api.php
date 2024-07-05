<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     // return $request->user();
//     $user = Auth::user();

//     return $user;
// });

// Route::middleware('auth:api')->get('/user',[AuthenticatedSessionController::class,'getUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthenticatedSessionController::class, 'getUser']);
    Route::post('logout', [AuthenticatedSessionController::class, 'logout']);
});

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('forgot-password',[PasswordResetLinkController::class,'sendVerificationCode']);
Route::post('verification',[PasswordResetLinkController::class,'verification']);
Route::post('reset-password',[PasswordResetLinkController::class,'resetPassword']);
// Route::post('logout', [AuthenticatedSessionController::class, 'logout']);

