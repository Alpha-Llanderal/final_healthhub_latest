@extends('layouts.app')

@section('title', 'HealthHub - Privacy Policy')

@section('content')
<div class="container-fluid bg-light py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Privacy Policy and Consent</h2>
                    <small class="text-white-50">
                        Last Updated: {{ now()->format('F d, Y') }}
                    </small>
                </div>

                <div class="card-body p-4 p-md-5">
                    @php
                        $sections = [
                            [
                                'title' => 'Introduction',
                                'content' => 'We value your privacy and are committed to protecting your personal health information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our Patient Portal.'
                            ],
                            [
                                'title' => 'Information We Collect',
                                'list' => [
                                    'Personal identification details (e.g., name, date of birth, patient ID)',
                                    'Contact information (e.g., email address, phone number)',
                                    'Medical records and health information',
                                    'Appointment details',
                                    'Login credentials'
                                ]
                            ],
                            [
                                'title' => 'How We Use Your Information',
                                'list' => [
                                    'Provide and manage your healthcare services',
                                    'Schedule and manage appointments',
                                    'Maintain medical records',
                                    'Communicate with you regarding your health and services',
                                    'Enhance user experience and improve our portal'
                                ]
                            ],
                            [
                                'title' => 'Disclosure of Your Information',
                                'list' => [
                                    'To healthcare providers involved in your care',
                                    'To comply with legal obligations or court orders',
                                    'With your consent or at your direction'
                                ]
                            ]
                        ];
                    @endphp

                    @foreach ($sections as $section)
                        <section class="mb-4 privacy-section">
                            <h4 class="text-primary mb-3">{{ $section['title'] }}</h4>
                            
                            @if(isset($section['content']))
                                <p>{{ $section['content'] }}</p>
                            @endif

                            @if(isset($section['list']))
                                <ul class="list-unstyled">
                                    @foreach ($section['list'] as $item)
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </section>
                    @endforeach

                    <section class="mb-4 privacy-section">
                        <h4 class="text-primary mb-3">Security of Your Information</h4>
                        <div class="alert alert-info">
                            <i class="bi bi-shield-lock me-2"></i>
                            We implement robust security measures to protect your personal information. However, no electronic transmission is 100% secure.
                        </div>
                    </section>

                    <section class="mb-4 privacy-section">
                        <h4 class="text-primary mb-3">Contact Us</h4>
                        <div class="contact-info bg-light p-3 rounded">
                            <p class="mb-2">
                                <strong>Email:</strong> 
                                <a href="mailto:support@healthhub.com" class="text-decoration-none">
                                    support@healthhub.com
                                </a>
                            </p>
                            <p class="mb-0">
                                <strong>Phone:</strong> 
                                <a href="tel:+18884227974" class="text-decoration-none">
                                    (888) 422-7974
                                </a>
                            </p>
                        </div>
                    </section>

                    <div class="text-center mt-5">
                        <div class="alert alert-warning mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            By continuing, you acknowledge that you have read and agree to our Privacy Policy
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

