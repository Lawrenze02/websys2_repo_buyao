@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1>Account Settings</h1>
        <p style="color: var(--text-muted);">Manage your profile information and security.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div style="background: #dcfce7; color: #15803d; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;">
            ✓ Your profile has been updated successfully.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div style="background: #dcfce7; color: #15803d; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;">
            ✓ Your password has been changed successfully.
        </div>
    @endif

    <div class="grid-2" style="grid-template-columns: 1fr; gap: 2rem;">
        <!-- Profile Info -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Profile Information</h3>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $user->middle_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Course</label>
                        <select name="course" class="form-control" required>
                            <option value="BSCS" {{ old('course', $user->course) == 'BSCS' ? 'selected' : '' }}>BS Computer Science</option>
                            <option value="BSIT" {{ old('course', $user->course) == 'BSIT' ? 'selected' : '' }}>BS Information Technology</option>
                            <option value="BSEE" {{ old('course', $user->course) == 'BSEE' ? 'selected' : '' }}>BS Electrical Engineering</option>
                            <option value="BSA" {{ old('course', $user->course) == 'BSA' ? 'selected' : '' }}>BS Accountancy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Year Level</label>
                        <select name="year_level" class="form-control" required>
                            <option value="1st Year" {{ old('year_level', $user->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                            <option value="2nd Year" {{ old('year_level', $user->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3rd Year" {{ old('year_level', $user->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4th Year" {{ old('year_level', $user->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2" required>{{ old('address', $user->address) }}</textarea>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Security -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Security</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Ensure your account is using a long, random password to stay secure.</p>
            
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
