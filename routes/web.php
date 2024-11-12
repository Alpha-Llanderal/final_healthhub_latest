<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::get('/', function () {
    return view('landing');
})->name('landing');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Privacy Policy
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy_policy');

// Forgot Password Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
->name('password.email');
// Password Reset Routes
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

////////// do not touch codes above this line //////////

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/preferences', [DashboardController::class, 'updatePreferences'])
         ->name('dashboard.preferences');
    Route::get('/dashboard/medical-info', [DashboardController::class, 'quickMedicalInfo'])
         ->name('dashboard.medical-info');


});