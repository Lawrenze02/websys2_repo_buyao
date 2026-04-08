@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 2rem auto;">
    <div class="card">
        <h2 style="margin-bottom: 0.5rem; text-align: center;">Student Registration</h2>
        <p style="color: var(--text-muted); text-align: center; margin-bottom: 2rem;">Join our academic community today.</p>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-control" placeholder="2024-XXXX" required value="{{ old('student_id') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="student@university.edu" required value="{{ old('email') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Course / Program</label>
                    <select name="course" class="form-control" required>
                        <option value="">Select Course</option>
                        <option value="BSCS" {{ old('course') == 'BSCS' ? 'selected' : '' }}>BS Computer Science</option>
                        <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>BS Information Technology</option>
                        <option value="BSEE" {{ old('course') == 'BSEE' ? 'selected' : '' }}>BS Electrical Engineering</option>
                        <option value="BSA" {{ old('course') == 'BSA' ? 'selected' : '' }}>BS Accountancy</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Year Level</label>
                    <select name="year_level" class="form-control" required>
                        <option value="">Select Year</option>
                        <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" required value="{{ old('birthdate') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" placeholder="09XXXXXXXXX" required value="{{ old('phone_number') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Home Address</label>
                <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
            </div>
        </form>

        <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
            Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Login here</a>
        </p>
    </div>
</div>
@endsection
