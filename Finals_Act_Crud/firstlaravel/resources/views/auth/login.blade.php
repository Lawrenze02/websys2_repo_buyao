@extends('layouts.app')

@section('content')
<div style="max-width: 450px; margin: 4rem auto;">
    <div class="card">
        <h2 style="margin-bottom: 0.5rem; text-align: center;">Welcome Back</h2>
        <p style="color: var(--text-muted); text-align: center; margin-bottom: 2rem;">Please enter your student credentials.</p>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Student ID</label>
                <input type="text" name="student_id" class="form-control" placeholder="e.g. 2024-001" required value="{{ old('student_id') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
            </div>
        </form>

        <p style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Register here</a>
        </p>
    </div>
</div>
@endsection
