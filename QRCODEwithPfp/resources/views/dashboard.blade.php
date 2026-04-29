@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Overview of your student records and system stats.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(108,99,255,.12);">
                <i class="bi bi-people-fill" style="color:#6c63ff;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(16,185,129,.12);">
                <i class="bi bi-mortarboard-fill" style="color:#10b981;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalCourses }}</div>
                <div class="stat-label">Courses</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(245,158,11,.12);">
                <i class="bi bi-qr-code-scan" style="color:#f59e0b;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-label">QR Codes Generated</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:rgba(59,130,246,.12);">
                <i class="bi bi-calendar3" style="color:#3b82f6;"></i>
            </div>
            <div>
                <div class="stat-value">{{ now()->format('Y') }}</div>
                <div class="stat-label">Academic Year</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Recent Students --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold" style="color:#0f1535;">Recent Students</h6>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentStudents->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <p class="mt-2 mb-0" style="font-size:.85rem;">No students yet. <a href="{{ route('students.create') }}">Add one now.</a></p>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentStudents as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($student->photo_url)
                                            <img src="{{ $student->photo_url }}" class="avatar" alt="">
                                        @else
                                            <div class="avatar-placeholder">{{ $student->initials }}</div>
                                        @endif
                                        <div>
                                            <div style="font-weight:600;font-size:.85rem;">{{ $student->full_name }}</div>
                                            <div style="font-size:.75rem;color:#6b7280;">{{ $student->student_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge-course">{{ $student->course }}</span></td>
                                <td>
                                    <span class="year-pill year-{{ $student->year_level }}">{{ $student->year_level }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Year Level Breakdown --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-bold" style="color:#0f1535;">Students by Year Level</h6>
            </div>
            <div class="card-body">
                @php $yearLabels = [1=>'1st Year',2=>'2nd Year',3=>'3rd Year',4=>'4th Year'];
                      $yearColors = [1=>'#10b981',2=>'#3b82f6',3=>'#f59e0b',4=>'#ef4444'];
                @endphp
                @foreach($yearLabels as $yr => $label)
                @php $count = $yearCounts[$yr] ?? 0; $pct = $totalStudents > 0 ? round(($count/$totalStudents)*100) : 0; @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.82rem; font-weight:500; color:#374151;">{{ $label }}</span>
                        <span style="font-size:.82rem; color:#6b7280;">{{ $count }} students</span>
                    </div>
                    <div class="progress" style="height:8px; border-radius:10px;">
                        <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $yearColors[$yr] }}; border-radius:10px;"></div>
                    </div>
                </div>
                @endforeach

                @if($totalStudents > 0)
                <hr style="border-color:#f0f3ff;">
                <h6 class="mb-3 fw-bold" style="font-size:.83rem; color:#0f1535;">Top Courses</h6>
                @foreach($courseCounts as $c)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge-course">{{ $c->course }}</span>
                    <span style="font-size:.8rem; color:#6b7280; font-weight:600;">{{ $c->total }}</span>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
