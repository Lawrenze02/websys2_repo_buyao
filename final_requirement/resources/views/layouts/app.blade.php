<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Expense Tracker') — FinanceFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #6366f1;
            --primary-dark:  #4f46e5;
            --primary-light: #a5b4fc;
            --success:       #10b981;
            --warning:       #f59e0b;
            --danger:        #ef4444;
            --bg:            #0f172a;
            --bg-card:       #1e293b;
            --bg-card2:      #273549;
            --border:        #334155;
            --text:          #f1f5f9;
            --text-muted:    #94a3b8;
            --sidebar-w:     260px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 1.75rem 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
        }

        .sidebar-logo .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
        }

        .sidebar-logo .logo-text {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .sidebar-logo .logo-text span { color: var(--primary-light); }

        .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0.75rem 0.75rem 0.35rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background: var(--bg-card2);
            color: var(--text);
        }

        .nav-link.active {
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary-light);
            font-weight: 600;
        }

        .nav-link .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--border);
        }

        .user-widget {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 10px;
            background: var(--bg-card2);
            margin-bottom: 0.75rem;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-info { overflow: hidden; }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 0.72rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout {
            width: 100%;
            padding: 0.65rem;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
            color: var(--danger);
        }

        /* ── Main content ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }

        .topbar-title {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .topbar-date {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        /* ── Alerts ── */
        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .alert-danger  { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.3);  color: #fca5a5; }
        .alert-warning { background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3); color: #fcd34d; }

        /* ── Cards ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
        }

        /* ── Form elements ── */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--bg-card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.9rem;
            color: var(--text);
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-control::placeholder { color: var(--text-muted); }

        select.form-select option { background: var(--bg-card); }

        .invalid-feedback {
            color: #fca5a5;
            font-size: 0.78rem;
            margin-top: 0.3rem;
        }
        .is-invalid { border-color: var(--danger) !important; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.7rem 1.4rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-family: inherit;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(99,102,241,0.35); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { filter: brightness(1.1); }
        .btn-danger  { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover  { background: var(--danger); color: #fff; }
        .btn-outline { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-outline:hover { background: var(--bg-card2); color: var(--text); }
        .btn-sm { padding: 0.4rem 0.85rem; font-size: 0.8rem; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; border-radius: 12px; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        th {
            padding: 0.85rem 1rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1rem 1rem;
            border-bottom: 1px solid rgba(51,65,85,0.5);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(99,102,241,0.04); }

        /* ── Badge / Category pill ── */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-food      { background: rgba(236,72,153,0.15); color: #f9a8d4; }
        .badge-transport { background: rgba(59,130,246,0.15); color: #93c5fd; }
        .badge-rent      { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .badge-other     { background: rgba(148,163,184,0.15); color: #cbd5e1; }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            gap: 0.3rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .pagination-wrap a, .pagination-wrap span {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-muted);
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .pagination-wrap a:hover { background: var(--bg-card2); color: var(--text); }
        .pagination-wrap span.active { background: var(--primary); color: #fff; border-color: var(--primary); }
        .pagination-wrap span.disabled { opacity: 0.4; cursor: default; }

        /* ── Grid ── */
        .grid { display: grid; gap: 1.25rem; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        @media (max-width: 1100px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 900px)  { .grid-3 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 700px)  {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }

        /* ── Stat cards ── */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            opacity: 0.08;
        }
        .stat-card.indigo::before  { background: var(--primary); }
        .stat-card.green::before   { background: var(--success); }
        .stat-card.amber::before   { background: var(--warning); }
        .stat-card.red::before     { background: var(--danger); }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1;
        }
        .stat-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
        }
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Sidebar ── --}}
<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">💸</div>
        <div class="logo-text">Finance<span>Flow</span></div>
    </a>

    <nav class="sidebar-nav">
        <span class="nav-section-label">Main</span>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <span class="nav-section-label">Expenses</span>

        <a href="{{ route('expenses.create') }}"
           class="nav-link {{ request()->routeIs('expenses.create') ? 'active' : '' }}">
            <span class="nav-icon">➕</span> Add Expense
        </a>

        <a href="{{ route('expenses.index') }}"
           class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> Expense History
        </a>

        <span class="nav-section-label">Settings</span>

        <a href="{{ route('budgets.index') }}"
           class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
            <span class="nav-icon">🎯</span> Budget Goals
        </a>

        <a href="{{ route('profile.settings') }}"
           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <span class="nav-icon">👤</span> Profile
        </a>
    </nav>

    <div class="sidebar-footer">
        @auth
        <div class="user-widget">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <span>🚪</span> Sign Out
            </button>
        </form>
        @endauth
    </div>
</aside>

{{-- ── Main wrapper ── --}}
<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-date">{{ now()->format('l, F j, Y') }}</div>
    </header>

    <main class="main-content">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
