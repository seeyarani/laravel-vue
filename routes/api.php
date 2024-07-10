<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthenticatedSessionController::class, 'getUser']);
    Route::post('logout', [AuthenticatedSessionController::class, 'logout']);
});

Route::post('register', [RegisteredUserController::class, 'store']);

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('forgot-password',[PasswordResetLinkController::class,'sendVerificationCode']);

Route::post('verification',[PasswordResetLinkController::class,'verification']);

Route::post('reset-password',[PasswordResetLinkController::class,'resetPassword']);


Route::post('get-projects',[ProjectController::class,'getProjects']);

Route::prefix('admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/',[UserController::class,'index']);
        Route::post('/',[UserController::class,'store']);
        Route::post('/edit',[UserController::class,'edit']);
        Route::post('/update',[UserController::class,'update']);
        Route::post('/delete',[UserController::class,'delete']);
    });

    Route::prefix('projects')->group(function () {
        Route::get('/',[ProjectController::class,'index']);
        Route::post('/',[ProjectController::class,'store']);
        Route::post('/edit',[ProjectController::class,'edit']);
        Route::post('/update',[ProjectController::class,'update']);
        Route::post('/delete',[ProjectController::class,'delete']);
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/',[TaskController::class,'index']);
        Route::post('/',[TaskController::class,'store']);
        Route::post('/edit',[TaskController::class,'edit']);
        Route::post('/update',[TaskController::class,'update']);
        Route::post('/delete',[TaskController::class,'delete']);
    });
});



