<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Step 1: Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Step 2: Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Login successful: Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();

            // Log successful login
            Log::info('Login successful for user: ' . Auth::user()->email);

            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . Auth::user()->first_name . '!');
        }

        // Login failed: Log attempt and return with error
        Log::warning('Login failed for email: ' . $credentials['email']);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $email = Auth::user()->email ?? 'unknown';
        
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log the logout event
        Log::info('User logged out: ' . $email);

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
