@extends('layouts.dashboard_app')
@section('title', 'HealthHub Connect')
@section('content')

<!-- MAIN CONTENT -->
<div class="mt-5 pt-3">
    <!-- Alert Section -->
    <div class="container my-3">
        <div class="alert alert-info text-center" role="alert">
            In an effort to provide the most efficient and effective patient care, please update your information prior to your visit.
        </div>
    </div>

<!-- Main / Body -->
<div class="container my-4">
    <div class="accordion" id="portalAccordion">
        <!-- PERSONAL INFORMATION SECTION -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPersonal">
                <button class="accordion-button bg-light text-dark fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                    <i class="bi bi-person-badge me-2"></i>Personal Information
                </button>
            </h2>
            <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal" data-bs-parent="#portalAccordion">
                <div class="accordion-body">
                    <!-- Profile Picture and Personal Details -->
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <!-- Profile Picture Upload -->
                            <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                                @csrf
                                <img id="profilePicture" 
                                    src="{{ $user->profile_picture ?? 'https://via.placeholder.com/150' }}" 
                                    class="rounded-circle img-fluid mb-3 mb-md-0" 
                                    alt="Profile Picture">
                                <div class="mt-2">
                                    <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-outline-secondary" id="uploadButton">
                                        <i class="bi bi-upload me-1"></i>Upload Photo
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" 
                                    class="form-control" 
                                    id="firstName" 
                                    value="{{ $user->first_name }}" 
                                    placeholder="First Name">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" 
                                    class="form-control" 
                                    id="lastName" 
                                    value="{{ $user->last_name }}" 
                                    placeholder="Last Name">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="birthDate" class="form-label">Date of Birth *</label>
                                    <input type="date" 
                                    class="form-control" 
                                    id="birthDate" 
                                    value="{{ $user->birth_date?->format('Y-m-d') }}" 
                                    placeholder="DD-MM-YYYY">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" 
                                    class="form-control" 
                                    id="email" 
                                        value="{{ $user->email }}" 
                                    placeholder="Email Address">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <input type="address" 
                                    class="form-control" 
                                    id="address" 
                                        value="{{ $user->address }}" 
                                    placeholder="Address">
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="phone_number" class="form-label">Phone Number *</label>
                                    <input type="phone_number" 
                                    class="form-control" 
                                    id="phone_number" 
                                        value="{{ $user->phone_number }}" 
                                    placeholder="Phone Number">
                                </div>


                            </div>
                        </div>
                    </div>
                    
                        <!-- Save Changes Button -->
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of Accordion -->  
        <!-- End of Personal Information Section -->

        </div> <!-- End of Container -->
    </div> <!-- End of Main Content Class -->    


@endsection
</body>
</html>