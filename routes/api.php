<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Client\ClientAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::post('forgot-password', [AdminAuthController::class, 'forgotPassword']);
});

Route::prefix('client')->group(function() {
    Route::post('register', [ClientAuthController::class, 'register']);
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::post('logout', [ClientAuthController::class, 'logout']);
    Route::post('forgot-password', [ClientAuthController::class, 'forgotPassword']);
});


// Route::post('client/login', [AuthController::class, 'clientLogin']);
// Route::post('client/register', [AuthController::class, 'clientRegister']);
// Route::post('client/logout', [AuthController::class, 'clientLogout']);

// Route::post('admin/login', [AuthController::class, 'adminLogin']);
// Route::post('admin/register', [AuthController::class, 'adminRegister']);
// Route::post('admin/logout', [AuthController::class, 'adminLogout']);
