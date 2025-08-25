<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{uuid}', [CategoryController::class, 'show']);
    Route::put('/{uuid}', [CategoryController::class, 'update']);
    Route::delete('/{uuid}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'accounts'], function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::post('/', [AccountController::class, 'store']);
    Route::get('/{uuid}', [AccountController::class, 'show']);
    Route::put('/{uuid}', [AccountController::class, 'update']);
    Route::delete('/{uuid}', [AccountController::class, 'destroy']);
});
