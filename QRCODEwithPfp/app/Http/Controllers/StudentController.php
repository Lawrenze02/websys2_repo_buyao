<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Student::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                  ->orWhere('first_name',   'like', "%{$search}%")
                  ->orWhere('last_name',    'like', "%{$search}%")
                  ->orWhere('email',        'like', "%{$search}%")
                  ->orWhere('course',       'like', "%{$search}%");
            });
        }

        // Filter by course
        if ($course = $request->input('course')) {
            $query->where('course', $course);
        }

        // Filter by year level
        if ($year = $request->input('year_level')) {
            $query->where('year_level', (int) $year);
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $courses  = Student::distinct()->orderBy('course')->pluck('course');

        return view('students.index', compact('students', 'courses'));
    }

    // ── Create ─────────────────────────────────────────────────────────────

    public function create()
    {
        return view('students.create');
    }

    // ── Store ──────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:20', 'unique:students'],
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'course'         => ['required', 'string', 'max:100'],
            'year_level'     => ['required', 'integer', 'between:1,4'],
            'email'          => ['required', 'email', 'max:255', 'unique:students'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'profile_photo'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            $file     = $request->file('profile_photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_photos', $filename);
            $validated['profile_photo'] = $filename;
        }

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student record created successfully.');
    }

    // ── Show ───────────────────────────────────────────────────────────────

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    // ── Edit ───────────────────────────────────────────────────────────────

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // ── Update ─────────────────────────────────────────────────────────────

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:20', 'unique:students,student_number,' . $student->id],
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'course'         => ['required', 'string', 'max:100'],
            'year_level'     => ['required', 'integer', 'between:1,4'],
            'email'          => ['required', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'phone'          => ['nullable', 'string', 'max:20'],
            'profile_photo'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($student->profile_photo) {
                Storage::delete('public/profile_photos/' . $student->profile_photo);
            }
            $file     = $request->file('profile_photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_photos', $filename);
            $validated['profile_photo'] = $filename;
        }

        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student record updated successfully.');
    }

    // ── Destroy ────────────────────────────────────────────────────────────

    public function destroy(Student $student)
    {
        if ($student->profile_photo) {
            Storage::delete('public/profile_photos/' . $student->profile_photo);
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student record deleted successfully.');
    }
}
