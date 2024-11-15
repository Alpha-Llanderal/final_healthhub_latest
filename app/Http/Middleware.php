<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    DashboardController,
    PrivacyPolicyController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};

// Public Routes (No Authentication Required)
Route::view('/', 'landing')->name('landing');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy_policy');

// Guest Routes (for non-authenticated users only)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset Routes
    Route::prefix('password')->name('password.')->group(function () {
        Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
        Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
        Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
        Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('update');
    });
});

// Protected Routes (Authenticated Users Only)
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::post('/update', [UserController::class, 'updateProfile'])->name('update');
        Route::post('/upload', [UserController::class, 'uploadProfilePicture'])->name('upload');

        // Address Management
        Route::get('/addresses', [UserController::class, 'getAddresses'])->name('addresses');
        Route::post('/address', [UserController::class, 'addAddress'])->name('address.add');
        Route::delete('/address/{id}', [UserController::class, 'deleteAddress'])->name('address.delete');

        // Phone Management
        Route::post('/phone', [UserController::class, 'addPhone'])->name('phone.add');
        Route::delete('/phone/{id}', [UserController::class, 'deletePhone'])->name('phone.delete');
    });
});

// Optional: API Routes (Authenticated via Sanctum)
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // Define API-specific routes here
});
