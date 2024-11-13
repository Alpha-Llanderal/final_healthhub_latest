<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');  // Add this constructor
    }

    public function showLoginForm()
    {
        // Remove the Auth::check() condition here - middleware will handle it
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        
        Log::info('Login attempt for email: ' . $credentials['email']);
        
        if (!$user) {
            Log::info('Login failed: User not found');
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->withInput($request->only('email', 'remember'));
        }

        Log::info('User exists in database: Yes');
        Log::info('Stored password hash: ' . $user->password);
        
        if (!Hash::check($credentials['password'], $user->password)) {
            Log::info('Login failed: Invalid password');
            return back()->withErrors([
                'password' => 'The provided password is incorrect.',
            ])->withInput($request->only('email', 'remember'));
        }

        // If we get here, both email and password are correct
        Auth::login($user, $request->boolean('remember'));
        Log::info('Login successful for user: ' . $user->email);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Welcome back, ' . $user->first_name . '!');
    }

    public function logout(Request $request)
    {
        $email = Auth::user()->email ?? 'unknown';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Log::info('User logged out: ' . $email);

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}