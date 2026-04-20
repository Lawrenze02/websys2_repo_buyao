<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Guest Routes ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Expenses
    Route::get('/expenses',          [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create',   [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses',         [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Budget settings
    Route::get('/budgets',           [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets',          [BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    // Profile
    Route::get('/profile',    [ProfileController::class, 'show'])->name('profile.settings');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
