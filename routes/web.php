<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Landing Page
Route::get('/', function () {return view('landing');})->name('landing');

// Privacy Policy
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy_policy');

// Guest Routes
Route::middleware('guest')->group(function () {
    // Authentication Routes
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

// Authentication Routes
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::post('/update', [UserController::class, 'updateProfile']);
        Route::get('/addresses', [UserController::class, 'getAddresses']);
        Route::post('/address', [UserController::class, 'addAddress']);
        Route::delete('/address/{id}', [UserController::class, 'deleteAddress']);
        Route::post('/phone', [UserController::class, 'addPhone']);
        Route::delete('/phone/{id}', [UserController::class, 'deletePhone']);
        Route::post('/upload', [UserController::class, 'uploadProfilePicture'])->name('profile.upload');
    });
});