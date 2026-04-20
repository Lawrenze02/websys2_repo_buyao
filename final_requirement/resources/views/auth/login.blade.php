<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FinanceFlow</title>
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
            padding:1rem;
        }
        .auth-card {
            background:#1e293b;
            border:1px solid #334155;
            border-radius:20px;
            padding:2.5rem;
            width:100%;
            max-width:420px;
            box-shadow:0 25px 60px rgba(0,0,0,0.5);
        }
        .auth-logo {
            text-align:center;
            margin-bottom:2rem;
        }
        .auth-logo .logo-icon {
            width:56px;height:56px;
            background:linear-gradient(135deg,#6366f1,#4f46e5);
            border-radius:16px;
            display:flex;align-items:center;justify-content:center;
            font-size:1.75rem;
            margin:0 auto 0.75rem;
        }
        .auth-logo h1 { font-size:1.5rem;font-weight:800;letter-spacing:-0.5px; }
        .auth-logo p  { color:#64748b;font-size:0.85rem;margin-top:0.25rem; }
        .form-group { margin-bottom:1.1rem; }
        .form-label {
            display:block;margin-bottom:0.4rem;
            font-size:0.78rem;font-weight:600;
            text-transform:uppercase;letter-spacing:0.05em;
            color:#94a3b8;
        }
        .form-control {
            width:100%;padding:0.75rem 1rem;
            background:#273549;border:1px solid #334155;
            border-radius:10px;font-size:0.9rem;
            color:#f1f5f9;font-family:inherit;
            transition:all 0.2s ease;
        }
        .form-control:focus {
            outline:none;border-color:#6366f1;
            box-shadow:0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-control::placeholder { color:#475569; }
        .invalid-feedback { color:#fca5a5;font-size:0.78rem;margin-top:0.3rem; }
        .is-invalid { border-color:#ef4444!important; }
        .btn {
            display:block;width:100%;
            padding:0.8rem;border:none;
            border-radius:10px;font-size:0.9rem;
            font-weight:700;cursor:pointer;
            font-family:inherit;transition:all 0.2s ease;
            text-align:center;text-decoration:none;
        }
        .btn-primary {
            background:linear-gradient(135deg,#6366f1,#4f46e5);
            color:#fff;
        }
        .btn-primary:hover {
            filter:brightness(1.1);
            transform:translateY(-1px);
            box-shadow:0 8px 20px rgba(99,102,241,0.35);
        }
        .alert-error {
            background:rgba(239,68,68,0.1);
            border:1px solid rgba(239,68,68,0.3);
            color:#fca5a5;
            padding:0.75rem 1rem;
            border-radius:10px;
            font-size:0.82rem;
            margin-bottom:1.25rem;
        }
        .auth-footer {
            text-align:center;
            margin-top:1.5rem;
            font-size:0.85rem;
            color:#64748b;
        }
        .auth-footer a { color:#818cf8;text-decoration:none;font-weight:600; }
        .auth-footer a:hover { color:#a5b4fc; }
        .divider {
            height:1px;background:#334155;margin:1.5rem 0;
            position:relative;
        }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">💸</div>
        <h1>FinanceFlow</h1>
        <p>Sign in to your account</p>
    </div>

    @if($errors->any())
    <div class="alert-error">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="username">User ID (or Username)</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                placeholder="e.g. 2024-00001"
                value="{{ old('username') }}"
                autofocus
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="Enter your password"
                required
            >
        </div>

        <div style="margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">🔐 Sign In</button>
        </div>
    </form>

    <div class="auth-footer">
        Don't have an account?
        <a href="{{ route('register') }}">Create one</a>
    </div>
</div>
</body>
</html>
