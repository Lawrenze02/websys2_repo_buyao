@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2>Edit Student: {{ $student->full_name }}</h2>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Student ID <span class="text-danger">*</span></label>
                    <input type="text" name="student_id" class="form-control" value="{{ old('student_id', $student->student_id) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $student->full_name) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Course/Program <span class="text-danger">*</span></label>
                    <input type="text" name="course" class="form-control" value="{{ old('course', $student->course) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Year Level <span class="text-danger">*</span></label>
                    <input type="text" name="year_level" class="form-control" value="{{ old('year_level', $student->year_level) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number (Optional)</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $student->contact_number) }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
