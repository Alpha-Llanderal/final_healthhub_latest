<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Validate the input
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Create the user and hash the password
            $user = $this->create($request->all());

            // Commit the transaction
            DB::commit();

            // Log the successful registration
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Redirect to the login page with a success message
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please log in.');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollBack();

            // Log the error details
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'input' => $request->except('password', 'password_confirmation')
            ]);

            // Redirect back with an error message
            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    /**
     * Validate the registration input data.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users,email'
            ],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed'
            ],
            'privacy_policy' => [
                'required', 
                'accepted'
            ]
        ], [
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'privacy_policy.required' => 'You must agree to the Privacy Policy to proceed.',
            'privacy_policy.accepted' => 'You must agree to the Privacy Policy to proceed.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Securely hash the password
        ]);
    }
}