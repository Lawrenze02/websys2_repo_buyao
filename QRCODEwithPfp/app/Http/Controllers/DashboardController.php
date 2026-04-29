<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents  = Student::count();
        $totalCourses   = Student::distinct('course')->count('course');
        $recentStudents = Student::latest()->take(5)->get();

        $yearCounts = Student::selectRaw('year_level, COUNT(*) as total')
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->pluck('total', 'year_level');

        $courseCounts = Student::selectRaw('course, COUNT(*) as total')
            ->groupBy('course')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'recentStudents',
            'yearCounts',
            'courseCounts'
        ));
    }
}
