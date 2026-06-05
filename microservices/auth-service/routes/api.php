<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Auth Service
|--------------------------------------------------------------------------
*/

// Public routes (tanpa token)
Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/resend-verification', [AuthController::class, 'resendVerification']);

    // Protected routes (perlu token Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::get('/validate-token', [AuthController::class, 'validateToken']);
        Route::put('/user/profile', [AuthController::class, 'updateProfile']);
        Route::put('/user/password', [AuthController::class, 'updatePassword']);
    });
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'service' => 'auth-service',
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String()
    ]);
});
