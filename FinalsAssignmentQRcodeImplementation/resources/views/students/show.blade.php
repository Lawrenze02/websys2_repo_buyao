@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Student Profile</h4>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-light">Back to List</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Student ID</th>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name</th>
                                    <td>{{ $student->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Course/Program</th>
                                    <td>{{ $student->course }}</td>
                                </tr>
                                <tr>
                                    <th>Year Level</th>
                                    <td>{{ $student->year_level }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td>{{ $student->contact_number ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 text-center">
                        <h5>Student QR Code</h5>
                        @php
                            $qrData = json_encode($student->only(['student_id', 'full_name', 'course', 'year_level', 'email', 'contact_number']));
                            $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($qrData);
                            $base64Svg = base64_encode($qrSvg);
                        @endphp
                        <div class="p-3 border rounded d-inline-block bg-white shadow-sm mb-3">
                            {!! $qrSvg !!}
                        </div>
                        <div>
                            <a href="data:image/svg+xml;base64,{{ $base64Svg }}" download="Student_{{ $student->student_id }}_QR.svg" class="btn btn-success">Download QR Code</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit Student</a>
            </div>
        </div>
    </div>
</div>
@endsection
