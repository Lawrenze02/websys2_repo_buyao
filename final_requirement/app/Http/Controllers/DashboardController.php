<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $month = now()->month;
        $year  = now()->year;

        // Total expenses this month
        $totalThisMonth = $user->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        // Budget for this month
        $budget = $user->budgets()
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        $monthlyLimit    = $budget ? $budget->monthly_limit : null;
        $remaining       = $monthlyLimit !== null ? $monthlyLimit - $totalThisMonth : null;
        $overBudget      = $monthlyLimit !== null && $totalThisMonth > $monthlyLimit;

        // Expenses grouped by category this month (for Chart.js)
        $byCategory = $user->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Last 5 expenses for quick view
        $recentExpenses = $user->expenses()
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalThisMonth',
            'monthlyLimit',
            'remaining',
            'overBudget',
            'byCategory',
            'recentExpenses',
            'budget'
        ));
    }
}
