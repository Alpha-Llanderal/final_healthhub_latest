@extends('layouts.app')
@section('title', 'HealthHub Connect - Login')
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
                            <h2 class="fw-bold">Patient Portal Login</h2>
                        </div>

                        <!-- Success and Error Messages -->
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show mb-3">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-3">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login.attempt') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Email Input -->
                            <div class="form-floating mb-3 position-relative">
                                <input type="email" 
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="Enter your email" 
                                    required 
                                    autocomplete="email"
                                    autofocus>
                                <label for="email">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" 
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    placeholder="Enter your password" 
                                    required
                                    autocomplete="current-password">
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>

                            <!-- Password Reset Link -->
                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    <i class="bi bi-unlock me-2"></i>Forgot Your Password?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Registration Link -->
                @if (Route::has('register'))
                    <div class="text-center mt-3">
                        <p>Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                Register Here
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Password Visibility Toggle
    const passwordInput = document.getElementById('password');
    const passwordContainer = passwordInput.closest('.form-floating');
    
    const togglePassword = document.createElement('button');
    togglePassword.innerHTML = '<i class="bi bi-eye"></i>';
    togglePassword.classList.add('btn', 'btn-outline-secondary', 'position-absolute', 'end-0', 'top-50', 'translate-middle-y', 'me-2', 'z-3');
    togglePassword.type = 'button';
    togglePassword.style.zIndex = '5';

    passwordContainer.appendChild(togglePassword);

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' 
            ? '<i class="bi bi-eye"></i>' 
            : '<i class="bi bi-eye-slash"></i>';
    });
});
</script>
@endpush