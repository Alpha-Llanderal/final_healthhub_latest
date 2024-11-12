@extends('layouts.app')

@section('title', 'HealthHub Connect')

@section('content')
<main>
    <section class="portal-container">
        <div class="card text-center p-4 mx-auto" style="max-width: 600px;">
            <div class="portal-logo mb-3">
                <img src="{{ asset('img/logo.png') }}" alt="HealthHub Logo" class="img-fluid mb-3">
                <h2 class="fw-bold">Patient Portal</h2>
                <p>Empowering you to take control of your health, one click at a time.</p>
                <div class="mt-4"> 
                    <a href="{{ route('register') }}" class="btn btn-primary me-2" aria-label="Register for Patient Portal">Register Here</a>
                    <a href="{{ route('login') }}" class="btn btn-success" aria-label="Login to Patient Portal">Login with Password</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection