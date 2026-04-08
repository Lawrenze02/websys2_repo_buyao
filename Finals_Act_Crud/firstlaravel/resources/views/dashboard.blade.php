@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1>Welcome, {{ Auth::user()->first_name }}!</h1>
    <p style="color: var(--text-muted);">Today is {{ date('l, F j, Y') }}</p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div class="card" style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Student Information</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <small style="color: var(--text-muted); font-weight: 600;">STUDENT ID</small>
                    <p style="font-weight: 500;">{{ Auth::user()->student_id }}</p>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 600;">EMAIL</small>
                    <p style="font-weight: 500;">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 600;">COURSE</small>
                    <p style="font-weight: 500;">{{ Auth::user()->course }}</p>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 600;">YEAR LEVEL</small>
                    <p style="font-weight: 500;">{{ Auth::user()->year_level }}</p>
                </div>
            </div>
            <div style="margin-top: 2rem;">
                <a href="{{ route('profile.settings') }}" class="btn btn-primary">Update Profile</a>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Recent Logs</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 1rem 0.5rem; color: var(--text-muted);">Event</th>
                            <th style="padding: 1rem 0.5rem; color: var(--text-muted);">Description</th>
                            <th style="padding: 1rem 0.5rem; color: var(--text-muted);">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\ActivityLog::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get() as $log)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 1rem 0.5rem;">
                                    <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600; font-size: 0.75rem; background: #e0e7ff; color: #4338ca;">
                                        {{ $log->event }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 0.5rem; font-size: 0.9rem;">{{ $log->description }}</td>
                                <td style="padding: 1rem 0.5rem; font-size: 0.9rem; color: var(--text-muted);">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 2rem; text-align: center; color: var(--text-muted);">No activity logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white;">
            <h3 style="margin-bottom: 1rem;">Portal Status</h3>
            <p style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 1.5rem;">Your account is currently active and all systems are operational.</p>
            <div style="padding: 1rem; background: rgba(255,255,255,0.1); border-radius: 8px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Database</span>
                    <span>Online</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Security</span>
                    <span>Enabled</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
