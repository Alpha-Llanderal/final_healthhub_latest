<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        // Attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Check user status
            if (!Auth::user()->is_active) {
                Auth::logout();
                return redirect()->route(' login')
                    ->with('error', 'Your account has been deactivated. Please contact support.');
            }

            // Regenerate session
            $request->session()->regenerate();

            // Redirect to dashboard
            return redirect()->route('dashboard')
                ->with('success', 'Welcome back, ' . Auth::user()->first_name . '!');
        }

        // If authentication fails
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}