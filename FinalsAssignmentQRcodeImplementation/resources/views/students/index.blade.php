@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Students List</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('students.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by Name, ID, or Course" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
            @if(request('search'))
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>QR Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td>
                            @php
                                $qrData = json_encode($student->only(['student_id', 'full_name', 'course', 'year_level', 'email', 'contact_number']));
                            @endphp
                            <div>
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($qrData) !!}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info text-white">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
