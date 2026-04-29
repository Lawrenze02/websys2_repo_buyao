<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ────────────────────────────────────────────────────────
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Students CRUD
Route::resource('students', StudentController::class);

