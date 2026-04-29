@extends('layouts.app')
@section('title', 'Add New Student')

@section('content')
<div class="page-header">
    <h1>Add New Student</h1>
    <p>Enter the student details and upload a profile picture.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="form-card">
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Student ID Number <span class="text-danger">*</span></label>
                        <input type="text" name="student_number" class="form-control @error('student_number') is-invalid @enderror" 
                               value="{{ old('student_number') }}" placeholder="e.g. 2024-0001" required>
                        @error('student_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="student@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                               value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                               value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                        <input type="text" name="course" class="form-control @error('course') is-invalid @enderror" 
                               value="{{ old('course') }}" placeholder="e.g. BS Computer Science" required>
                        @error('course')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Year Level <span class="text-danger">*</span></label>
                        <select name="year_level" class="form-select @error('year_level') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Year</option>
                            @foreach([1=>'1st Year', 2=>'2nd Year', 3=>'3rd Year', 4=>'4th Year'] as $val => $label)
                                <option value="{{ $val }}" {{ old('year_level') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('year_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" placeholder="e.g. 09123456789">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Max size: 2MB (JPG, PNG, WebP)</small>
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-check2-circle me-2"></i>Save Student
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Tips</h6>
            </div>
            <div class="card-body">
                <ul class="text-muted mb-0" style="font-size: .85rem; padding-left: 1.2rem;">
                    <li class="mb-2">Student ID must be unique.</li>
                    <li class="mb-2">Ensure the email address is valid.</li>
                    <li class="mb-2">Upload a clear square photo for best results.</li>
                    <li>QR code will be automatically generated upon saving.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
