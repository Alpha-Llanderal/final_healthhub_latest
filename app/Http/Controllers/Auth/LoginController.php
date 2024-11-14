<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
        // Step 1: Validate the input data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        // Log the login attempt
        Log::info('Login attempt for email: ' . $credentials['email']);
        
        // Step 2: Find the user by email
        $user = User::where('email', $credentials['email'])->first();
    
        // Step 3: Check if the user exists and if the password matches
        if (!$user) {
            Log::warning('No user found with email: ' . $credentials['email']);
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        } elseif (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Password verification failed for email: ' . $credentials['email']);
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        } else {
            Log::info('Login successful for email: ' . $credentials['email']);
        }
    
        // Step 4: Log the user in and regenerate session
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
    
        return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
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
