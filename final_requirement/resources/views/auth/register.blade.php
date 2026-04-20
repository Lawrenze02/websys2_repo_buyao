<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — FinanceFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body {
            font-family:'Inter',sans-serif;
            background:#0f172a;
            color:#f1f5f9;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem 1rem;
        }
        .auth-card {
            background:#1e293b;
            border:1px solid #334155;
            border-radius:20px;
            padding:2.5rem;
            width:100%;
            max-width:760px;
            box-shadow:0 25px 60px rgba(0,0,0,0.5);
        }
        .auth-logo {
            text-align:center;
            margin-bottom:2rem;
        }
        .auth-logo .logo-icon {
            width:52px;height:52px;
            background:linear-gradient(135deg,#6366f1,#4f46e5);
            border-radius:14px;
            display:flex;align-items:center;justify-content:center;
            font-size:1.6rem;
            margin:0 auto 0.75rem;
        }
        .auth-logo h1 {font-size:1.4rem;font-weight:800;letter-spacing:-0.5px;}
        .auth-logo p  {color:#64748b;font-size:0.85rem;margin-top:0.25rem;}
        .section-title {
            font-size:0.7rem;font-weight:700;
            text-transform:uppercase;letter-spacing:0.1em;
            color:#6366f1;margin:1.5rem 0 1rem;
            display:flex;align-items:center;gap:0.5rem;
        }
        .section-title::after {
            content:'';flex:1;height:1px;background:#334155;
        }
        .grid { display:grid; gap:0.85rem; }
        .grid-2 { grid-template-columns: 1fr 1fr; }
        .grid-3 { grid-template-columns: 1fr 1fr 1fr; }
        @media(max-width:600px){
            .grid-2,.grid-3 { grid-template-columns:1fr; }
        }
        .form-group { display:flex;flex-direction:column;gap:0.35rem; }
        .form-label {
            font-size:0.75rem;font-weight:600;
            text-transform:uppercase;letter-spacing:0.05em;
            color:#94a3b8;
        }
        .form-control,.form-select {
            padding:0.7rem 0.9rem;
            background:#273549;border:1px solid #334155;
            border-radius:10px;font-size:0.875rem;
            color:#f1f5f9;font-family:inherit;
            transition:all 0.2s ease;
            width:100%;
        }
        .form-control:focus,.form-select:focus {
            outline:none;border-color:#6366f1;
            box-shadow:0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-control::placeholder{color:#475569;}
        select.form-select option{background:#1e293b;}
        .invalid-feedback{color:#fca5a5;font-size:0.75rem;}
        .is-invalid{border-color:#ef4444!important;}
        .alert-error {
            background:rgba(239,68,68,0.1);
            border:1px solid rgba(239,68,68,0.3);
            color:#fca5a5;
            padding:0.75rem 1rem;
            border-radius:10px;
            font-size:0.82rem;
            margin-bottom:1.25rem;
        }
        .btn-submit {
            display:block;width:100%;
            padding:0.85rem;border:none;
            border-radius:12px;
            font-size:0.95rem;font-weight:700;
            cursor:pointer;font-family:inherit;
            background:linear-gradient(135deg,#6366f1,#4f46e5);
            color:#fff;margin-top:1.75rem;
            transition:all 0.2s ease;
        }
        .btn-submit:hover {
            filter:brightness(1.1);
            transform:translateY(-1px);
            box-shadow:0 8px 20px rgba(99,102,241,0.35);
        }
        .auth-footer {
            text-align:center;margin-top:1.5rem;
            font-size:0.85rem;color:#64748b;
        }
        .auth-footer a{color:#818cf8;text-decoration:none;font-weight:600;}
        .auth-footer a:hover{color:#a5b4fc;}
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">💸</div>
        <h1>Create Your Account</h1>
        <p>Join FinanceFlow and start tracking your expenses</p>
    </div>

    @if($errors->any())
    <div class="alert-error">
        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.25rem;">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Account Info --}}
        <div class="grid grid-2">
            <div class="form-group">
                <label class="form-label" for="username">User ID (Username)</label>
                <input type="text" id="username" name="username"
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="e.g. 2024-00001" value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="you@email.com" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Personal Info --}}
        <div class="form-group" style="margin-top:0.85rem;">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name"
                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                placeholder="Juan Dela Cruz" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Password --}}
        <div class="section-title">Password</div>
        <div class="grid grid-2">
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Min. 8 characters" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="Repeat password" required>
            </div>
        </div>

        <button type="submit" class="btn-submit">🚀 Create My Account</button>
    </form>

    <div class="auth-footer">
        Already have an account?
        <a href="{{ route('login') }}">Sign in here</a>
    </div>
</div>
</body>
</html>
