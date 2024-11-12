@extends('layouts.app')
@section('title', 'HealthHub Connect - Register')
@section('content')

<main class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Logo and Title -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/logo.png') }}" 
                                 alt="HealthHub Logo" 
                                 class="img-fluid mb-3"
                                 width="150">
                            <h2 class="fw-bold">Patient Registration</h2>
                        </div>

                        <!-- Display Messages -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}" 
                              class="needs-validation" 
                              novalidate 
                              enctype="multipart/form-data">
                            @csrf
                            
                            <!-- First Name Input -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       id="firstName"
                                       class="form-control @error('first_name') is-invalid @enderror" 
                                       name="first_name" 
                                       value="{{ old('first_name') }}" 
                                       placeholder="Enter your first name" 
                                       required 
                                       autofocus>
                                <label for="firstName">First Name</label>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name Input -->
                            <div class="form-floating mb-3">
                                <input type="text" 
                                       id="lastName"
                                       class="form-control @error('last_name') is-invalid @enderror" 
                                       name="last_name" 
                                       value="{{ old('last_name') }}" 
                                       placeholder="Enter your last name" 
                                       required>
                                <label for="lastName">Last Name</label>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="form-floating mb-3">
                                <input type="email" 
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your email" 
                                       required>
                                <label for="email">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required>
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="form-floating mb-3">
                                <input type="password" 
                                       id="password_confirmation"
                                       class="form-control" 
                                       name="password_confirmation" 
                                       placeholder="Confirm your password" 
                                       required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>

                            <!-- Privacy Policy Consent -->
                            <div class="form-check mb-3">
                                <input type="checkbox" 
                                    id="privacyPolicy"
                                    class="form-check-input @error('privacy_policy') is-invalid @enderror" 
                                    name="privacy_policy" 
                                    value="1"
                                    required>
                                <label class="form-check-label" for="privacyPolicy">
                                    I have read and agree to the 
                                    <a href="{{ route('privacy_policy') }}" target="_blank" class="text-primary">Privacy Policy</a>
                                    <span class="text-danger">*</span>
                                </label>
                                @error('privacy_policy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-person-plus-fill me-2"></i>Register </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    Already have an account? Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Client-side validation
    const form = document.querySelector('form');
    const privacyPolicyCheckbox = document.getElementById('privacyPolicy');

    // Initialize Bootstrap tooltip
    new bootstrap.Tooltip(privacyPolicyCheckbox);

    // Custom validation function
    function validatePrivacyPolicy() {
        if (!privacyPolicyCheckbox.checked) {
            privacyPolicyCheckbox.classList.add('is-invalid');
            privacyPolicyCheckbox.setCustomValidity('You must agree to the Privacy Policy');
            return false;
        } else {
            privacyPolicyCheckbox.classList.remove('is-invalid');
            privacyPolicyCheckbox.setCustomValidity('');
            return true;
        }
    }

    // Add event listeners for validation
    privacyPolicyCheckbox.addEventListener('change', validatePrivacyPolicy);
    
    // Form submission validation
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validatePrivacyPolicy()) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    }
});
</script>
@endpush