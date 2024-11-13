<?php
use Illuminate\Support\Facades\Route;

// Controllers
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
Route::controller(PrivacyPolicyController::class)->group(function () {
    Route::get('/', 'showLanding')->name('landing');
    Route::get('/privacy-policy', 'show')->name('privacy_policy');
});

// Guest Routes (for non-authenticated users only)
Route::middleware('guest')->group(function () {
    // Authentication Routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.attempt');
    });
    
    // Registration Routes
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'showRegistrationForm')->name('register');
        Route::post('/register', 'register');
    });
    
    // Password Reset Routes
    Route::prefix('password')->name('password.')->group(function () {
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('/reset', 'showLinkRequestForm')->name('request');
            Route::post('/email', 'sendResetLinkEmail')->name('email');
        });

        Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('/reset/{token}', 'showResetForm')->name('reset');
            Route::post('/reset', 'reset')->name('update');
        });
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
        Route::controller(UserController::class)->group(function () {
            // Profile Update
            Route::post('/update', 'updateProfile')->name('update');
            Route::post('/upload', 'uploadProfilePicture')->name('upload');

            // Address Management
            Route::get('/addresses', 'getAddresses')->name('addresses');
            Route::post('/address', 'addAddress')->name('address.add');
            Route::delete('/address/{id}', 'deleteAddress')->name('address.delete');

            // Phone Management
            Route::post('/phone', 'addPhone')->name('phone.add');
            Route::delete('/phone/{id}', 'deletePhone')->name('phone.delete');
        });
    });
});

// Optional: API Routes
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // Add API-specific routes here
});