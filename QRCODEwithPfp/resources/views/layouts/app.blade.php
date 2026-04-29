<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Student QR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f1535;
            --sidebar-width: 260px;
            --accent: #6c63ff;
            --accent-hover: #574fd6;
            --bg: #f0f3ff;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed; top: 0; left: 0; z-index: 1040;
            display: flex; flex-direction: column;
            transition: transform .3s;
        }
        .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg,#6c63ff,#3a36db);
            display:flex; align-items:center; justify-content:center;
            font-size: 1.2rem; color: #fff; flex-shrink: 0;
        }
        .sidebar-brand h6 { color:#fff; font-weight:700; margin:0; font-size:.92rem; line-height:1.3; }
        .sidebar-brand small { color:rgba(255,255,255,.45); font-size:.7rem; font-weight:400; }
        .nav-section-label {
            color: rgba(255,255,255,.35); font-size:.65rem;
            text-transform:uppercase; letter-spacing:1.5px;
            padding: 18px 20px 6px; font-weight:600;
        }
        .sidebar-nav .nav-link {
            color:rgba(255,255,255,.65); padding:10px 14px; margin: 2px 10px;
            border-radius:10px; display:flex; align-items:center; gap:12px;
            font-size:.85rem; font-weight:500; transition:all .2s; text-decoration:none;
        }
        .sidebar-nav .nav-link i { font-size:1rem; width:20px; text-align:center; }
        .sidebar-nav .nav-link:hover { background:rgba(255,255,255,.08); color:#fff; }
        .sidebar-nav .nav-link.active { background:var(--accent); color:#fff; box-shadow: 0 4px 15px rgba(108,99,255,.4); }
        .sidebar-footer {
            margin-top:auto; padding:16px 20px;
            border-top:1px solid rgba(255,255,255,.08);
        }
        .sidebar-footer .user-name { color:#fff; font-size:.82rem; font-weight:600; }
        .sidebar-footer .user-email { color:rgba(255,255,255,.45); font-size:.72rem; }
        .sidebar-footer .logout-btn {
            background:rgba(255,255,255,.08); border:none; color:rgba(255,255,255,.6);
            padding:6px 14px; border-radius:8px; font-size:.78rem; cursor:pointer;
            transition:all .2s; margin-top:10px; width:100%; text-align:left;
            display:flex; align-items:center; gap:8px;
        }
        .sidebar-footer .logout-btn:hover { background:rgba(239,68,68,.25); color:#fca5a5; }

        /* ── Main ── */
        .main-content { margin-left:var(--sidebar-width); min-height:100vh; }
        .topbar {
            background:#fff; border-bottom:1px solid #e8edf5;
            padding:12px 28px; position:sticky; top:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between;
        }
        .topbar .page-title { font-weight:700; font-size:1rem; color:#0f1535; margin:0; }
        .topbar .breadcrumb { margin:0; font-size:.78rem; }
        .topbar .breadcrumb-item.active { color:#6b7280; }
        .content-area { padding:28px; }

        /* ── Cards ── */
        .card { border:none; border-radius:16px; box-shadow:0 2px 16px rgba(15,21,53,.07); }
        .card-header { background:#fff; border-bottom:1px solid #f0f3ff; border-radius:16px 16px 0 0 !important; padding:18px 24px; }

        /* ── Stat cards ── */
        .stat-card { padding:24px; border-radius:16px; background:#fff; box-shadow:0 2px 16px rgba(15,21,53,.07); }
        .stat-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; }
        .stat-value { font-size:1.8rem; font-weight:700; color:#0f1535; margin:8px 0 2px; line-height:1; }
        .stat-label { color:#6b7280; font-size:.8rem; font-weight:500; }

        /* ── Table ── */
        .table thead th { background:#f8f9fc; color:#6b7280; font-size:.72rem; text-transform:uppercase; letter-spacing:.6px; font-weight:600; border-bottom:none; padding:12px 16px; }
        .table tbody td { padding:13px 16px; vertical-align:middle; color:#374151; font-size:.85rem; border-bottom:1px solid #f5f7ff; }
        .table tbody tr:hover { background:#fafbff; }
        .table tbody tr:last-child td { border-bottom:none; }

        /* ── Badges ── */
        .badge-course { background:rgba(108,99,255,.1); color:var(--accent); padding:4px 10px; border-radius:20px; font-size:.73rem; font-weight:600; }
        .year-pill {
            display:inline-flex; align-items:center; justify-content:center;
            width:28px; height:28px; border-radius:50%;
            font-size:.72rem; font-weight:700; color:#fff;
        }
        .year-1 { background:#10b981; } .year-2 { background:#3b82f6; }
        .year-3 { background:#f59e0b; } .year-4 { background:#ef4444; }

        /* ── Avatar ── */
        .avatar { width:38px; height:38px; border-radius:10px; object-fit:cover; }
        .avatar-placeholder {
            width:38px; height:38px; border-radius:10px;
            background:linear-gradient(135deg,var(--accent),#3a36db);
            display:inline-flex; align-items:center; justify-content:center;
            color:#fff; font-weight:700; font-size:.8rem;
        }
        .avatar-lg { width:100px; height:100px; border-radius:20px; object-fit:cover; }
        .avatar-placeholder-lg {
            width:100px; height:100px; border-radius:20px;
            background:linear-gradient(135deg,var(--accent),#3a36db);
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-weight:700; font-size:2rem;
        }

        /* ── Forms ── */
        .form-control, .form-select {
            border-radius:10px; border:1.5px solid #e2e8f0;
            padding:10px 14px; font-size:.875rem; transition:all .2s;
        }
        .form-control:focus, .form-select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,.15); }
        .form-label { font-weight:500; font-size:.84rem; color:#374151; margin-bottom:6px; }
        .form-card { background:#fff; border-radius:16px; padding:32px; box-shadow:0 2px 16px rgba(15,21,53,.07); }

        /* ── Buttons ── */
        .btn-primary { background:var(--accent); border-color:var(--accent); font-weight:500; }
        .btn-primary:hover { background:var(--accent-hover); border-color:var(--accent-hover); }
        .btn-sm { padding:5px 12px; font-size:.78rem; border-radius:8px; }

        /* ── QR card ── */
        .qr-wrapper { background:#f8f9fc; border-radius:16px; padding:24px; text-align:center; }
        .qr-wrapper img { border-radius:12px; max-width:260px; }

        /* ── Alert flash ── */
        .flash-alert { border-radius:12px; font-size:.875rem; border:none; }

        /* ── Page header ── */
        .page-header { margin-bottom:24px; }
        .page-header h1 { font-size:1.4rem; font-weight:700; color:#0f1535; margin:0 0 4px; }
        .page-header p { color:#6b7280; font-size:.85rem; margin:0; }

        /* ── Responsive ── */
        @media (max-width:768px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:translateX(0); }
            .main-content { margin-left:0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-qr-code"></i></div>
        <div>
            <h6>Student QR System</h6>
            <small>Management Portal</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Records</div>
        <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> All Students
        </a>
        <a href="{{ route('students.create') }}" class="nav-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i> Add Student
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="avatar-placeholder" style="width:34px;height:34px;font-size:.75rem;border-radius:8px;">
                G
            </div>
            <div>
                <div class="user-name">Guest User</div>
                <div class="user-email">Public Access</div>
            </div>
        </div>
    </div>

</aside>

{{-- Main Content --}}
<div class="main-content">
    <div class="topbar">
        <div>
            <p class="page-title">@yield('title', 'Dashboard')</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:.8rem"><i class="bi bi-clock me-1"></i>{{ now()->format('M d, Y') }}</span>
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <div class="content-area">
        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success flash-alert d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger flash-alert d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
