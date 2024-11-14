<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Ensure only one `/user` route is defined, protected by `auth:sanctum`
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User management routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users', [UserController::class, 'store']);        // Create user
    Route::put('/users/{user}', [UserController::class, 'update']); // Update user
    Route::get('/users/{user}', [UserController::class, 'show']);   // Show user details
});
