<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $month = now()->month;
        $year  = now()->year;

        // Current month's budget
        $budget = $user->budgets()
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        // All budgets for history
        $allBudgets = $user->budgets()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('budgets.index', compact('budget', 'allBudgets', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'monthly_limit' => ['required', 'numeric', 'min:1'],
            'month'         => ['required', 'integer', 'between:1,12'],
            'year'          => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $validated['user_id'] = Auth::id();

        Budget::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'month'   => $validated['month'],
                'year'    => $validated['year'],
            ],
            ['monthly_limit' => $validated['monthly_limit']]
        );

        return redirect()->route('budgets.index')
            ->with('success', 'Budget saved successfully!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget removed successfully!');
    }
}
