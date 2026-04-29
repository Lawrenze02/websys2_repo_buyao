@extends('layouts.app')
@section('title', 'Student Profile — ' . $student->full_name)

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1>Student Profile</h1>
            <p>Full details and generated QR identification.</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="{{ route('students.destroy', $student) }}"
            onsubmit="return confirm('Are you sure you want to delete this student record?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    {{-- Personal Info --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-4 mb-5 pb-4 border-bottom">
                    @if($student->photo_url)
                        <img src="{{ $student->photo_url }}" class="avatar-lg" alt="{{ $student->full_name }}">
                    @else
                        <div class="avatar-placeholder-lg">{{ $student->initials }}</div>
                    @endif
                    <div class="text-center text-sm-start">
                        <h2 class="fw-bold mb-1" style="color:#0f1535;">{{ $student->full_name }}</h2>
                        <p class="text-muted mb-2"><i class="bi bi-card-text me-2"></i>{{ $student->student_number }}</p>
                        <span class="badge-course">{{ $student->course }}</span>
                        <span class="ms-2 year-pill year-{{ $student->year_level }}">{{ $student->year_level }}</span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="text-muted d-block mb-1" style="font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Email Address</label>
                            <div class="fw-medium">{{ $student->email }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted d-block mb-1" style="font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Phone Number</label>
                            <div class="fw-medium">{{ $student->phone ?? 'Not provided' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="text-muted d-block mb-1" style="font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Year Level</label>
                            <div class="fw-medium">{{ $student->year_label }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted d-block mb-1" style="font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Date Registered</label>
                            <div class="fw-medium">{{ $student->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QR Code Section --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">QR Identification</h6>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-5">
                <div class="qr-wrapper mb-4">
                    <img src="{{ $student->qr_code_url }}" alt="QR Code" class="img-fluid">
                </div>
                <p class="text-muted px-4" style="font-size:.85rem;">
                    This QR code contains the student's digital identification data for scanning and verification.
                </p>
                <button class="btn btn-light btn-sm mt-2" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Print ID
                </button>
            </div>
        </div>
    </div>
    {{-- Discover Others Section --}}
    <div class="col-12 mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold" style="color: #0f1535;">Discover Other Students</h6>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">View All</a>
            </div>
            <div class="card-body pt-0 pb-4">
                <div class="row g-3">
                    @php 
                        $others = \App\Models\Student::where('id', '!=', $student->id)->inRandomOrder()->take(4)->get();
                    @endphp
                    @forelse($others as $other)
                    <div class="col-md-3">
                        <a href="{{ route('students.show', $other) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center gap-3 p-3 border rounded-4 hover-bg h-100 transition-all">
                                @if($other->photo_url)
                                    <img src="{{ $other->photo_url }}" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;" alt="">
                                @else
                                    <div class="avatar-placeholder rounded-circle" style="width:40px; height:40px; font-size:.75rem;">{{ $other->initials }}</div>
                                @endif
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark mb-0 text-truncate" style="font-size:.85rem;">{{ $other->full_name }}</div>
                                    <div class="text-muted text-truncate" style="font-size:.75rem;">{{ $other->course }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4 text-muted">
                        <i class="bi bi-people mb-2 d-block fs-4"></i>
                        <span style="font-size:.85rem;">No other students found.</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-bg { transition: all 0.2s ease; border: 1.5px solid #f0f3ff !important; }
    .hover-bg:hover { background: #f8faff; border-color: #6c63ff !important; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(108,99,255,0.08); }
    .transition-all { transition: all 0.2s ease; }
</style>

@push('styles')
<style>
    @media print {
        .sidebar, .topbar, .btn, .page-header p, .card-header { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .content-area { padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        .row { display: block !important; }
        .col-lg-8, .col-lg-4 { width: 100% !important; margin-bottom: 20px; }
        .qr-wrapper img { max-width: 200px !important; }
    }
</style>
@endpush
@endsection
