@extends('layouts.app')

@section('title', 'Profile Settings')
@section('page-title', '👤 Profile Settings')

@push('styles')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    @media(max-width:800px){ .profile-grid { grid-template-columns: 1fr; } }
    .profile-avatar-card {
        text-align: center;
        padding: 2.5rem 1.5rem;
    }
    .big-avatar {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 800;
        margin: 0 auto 1rem;
        color: #fff;
    }
    .avatar-name { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.25rem; }
    .avatar-id   { color: #94a3b8; font-size: 0.85rem; }
    .stats-mini  { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 1.5rem; }
    .mini-stat {
        background: #273549;
        border-radius: 10px;
        padding: 0.85rem;
        text-align: center;
    }
    .mini-stat-val  { font-size: 1.25rem; font-weight: 800; color: #a5b4fc; }
    .mini-stat-lbl  { font-size: 0.7rem; color: #94a3b8; margin-top: 0.15rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; }
    @media(max-width:500px){ .form-row { grid-template-columns: 1fr; } }
    .section-label {
        font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        color: #6366f1; margin: 1.25rem 0 0.85rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .section-label::after { content: ''; flex: 1; height: 1px; background: #334155; }
    .status-pill {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.4rem 1rem; border-radius: 999px;
        font-size: 0.8rem; font-weight: 600;
        background: rgba(16,185,129,0.1);
        border: 1px solid rgba(16,185,129,0.2);
        color: #6ee7b7;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')

<div class="profile-grid">

    {{-- ── Left: Avatar card ── --}}
    <div class="card profile-avatar-card" style="grid-row: span 2;">
        @if(session('status') === 'profile-updated')
            <div class="status-pill">✅ Profile updated successfully</div>
        @endif
        @if(session('status') === 'password-updated')
            <div class="status-pill">🔐 Password changed successfully</div>
        @endif

        <div class="big-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="avatar-name">{{ $user->name }}</div>
        <div class="avatar-id">User ID: {{ $user->username }}</div>
        <div style="color:#64748b;font-size:0.8rem;margin-top:0.25rem;">{{ $user->email }}</div>

        <div class="stats-mini">
            <div class="mini-stat">
                <div class="mini-stat-val">{{ $user->expenses()->count() }}</div>
                <div class="mini-stat-lbl">Expenses</div>
            </div>
            <div class="mini-stat">
                <div class="mini-stat-val">{{ $user->budgets()->count() }}</div>
                <div class="mini-stat-lbl">Budgets</div>
            </div>
            <div class="mini-stat">
                <div class="mini-stat-val">₱{{ number_format($user->expenses()->whereMonth('date', now()->month)->sum('amount'), 0) }}</div>
                <div class="mini-stat-lbl">This Month</div>
            </div>
            <div class="mini-stat">
                <div class="mini-stat-val">{{ $user->created_at->format('Y') }}</div>
                <div class="mini-stat-lbl">Member Since</div>
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;flex-direction:column;gap:0.5rem;">
            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">➕ Add Expense</a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;">📊 Dashboard</a>
        </div>
    </div>

    {{-- ── Right Top: Update profile ── --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:0.25rem;">Update Profile</div>
        <p style="color:#64748b;font-size:0.8rem;">Change your personal information.</p>

        @if($errors->has('name') || $errors->has('email'))
        <div class="alert alert-danger" style="margin-top:1rem;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-group" style="margin-top:1rem;">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" id="name" name="name"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email', $user->email) }}" required>
            </div>

            <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
                <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            </div>
        </form>
    </div>

    {{-- ── Right Bottom: Change Password ── --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:0.25rem;">Change Password</div>
        <p style="color:#64748b;font-size:0.8rem;">Keep your account secure.</p>

        @if($errors->has('current_password') || $errors->has('password'))
        <div class="alert alert-danger" style="margin-top:1rem;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-top:1rem;">
                <label class="form-label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                    class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                    placeholder="Your current password" required>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="new_password">New Password</label>
                <input type="password" id="new_password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Min. 8 characters" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="Repeat new password" required>
            </div>

            <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
                <button type="submit" class="btn btn-primary">🔐 Update Password</button>
            </div>
        </form>
    </div>

</div>
@endsection
