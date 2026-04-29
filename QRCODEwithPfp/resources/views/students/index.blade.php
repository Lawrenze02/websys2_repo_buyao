@extends('layouts.app')
@section('title', 'All Students')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>All Students</h1>
        <p>Manage student records and their QR codes.</p>
    </div>
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Student
    </a>
</div>

{{-- Search & Filter --}}
<div class="card mb-4">
    <div class="card-body" style="padding:20px 24px;">
        <form method="GET" action="{{ route('students.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f8f9fc; border:1.5px solid #e2e8f0; border-right:none; border-radius:10px 0 0 10px;">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control" style="border-left:none; border-radius:0 10px 10px 0;"
                        value="{{ request('search') }}" placeholder="Name, ID, email, course…">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Course</label>
                <select name="course" class="form-select">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course }}" {{ request('course') === $course ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Year Level</label>
                <select name="year_level" class="form-select">
                    <option value="">All Years</option>
                    @foreach([1=>'1st Year',2=>'2nd Year',3=>'3rd Year',4=>'4th Year'] as $yr => $label)
                        <option value="{{ $yr }}" {{ request('year_level') == $yr ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Filter</button>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold" style="color:#0f1535;">
            Students
            <span class="badge bg-secondary ms-2" style="font-size:.72rem;">{{ $students->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        @if($students->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people" style="font-size:2.5rem;"></i>
                <p class="mt-2 mb-0">No students found. <a href="{{ route('students.create') }}">Add one now.</a></p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Student No.</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $i => $student)
                    <tr>
                        <td style="color:#9ca3af;">{{ $students->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($student->photo_url)
                                    <img src="{{ $student->photo_url }}" class="avatar" alt="">
                                @else
                                    <div class="avatar-placeholder">{{ $student->initials }}</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;">{{ $student->full_name }}</div>
                                    <div style="font-size:.74rem;color:#9ca3af;">{{ $student->phone ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-family:monospace; font-size:.82rem;">{{ $student->student_number }}</td>
                        <td><span class="badge-course">{{ $student->course }}</span></td>
                        <td>
                            @php $yc=['year-1','year-2','year-3','year-4']; @endphp
                            <span class="year-pill {{ $yc[$student->year_level-1] ?? '' }}">{{ $student->year_level }}</span>
                        </td>
                        <td style="font-size:.82rem;">{{ $student->email }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('students.destroy', $student) }}"
                                    onsubmit="return confirm('Delete {{ addslashes($student->full_name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top:1px solid #f0f3ff;">
            <div style="font-size:.8rem; color:#6b7280;">
                Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} students
            </div>
            {{ $students->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
