<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->expenses();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $expenses   = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(10)->withQueryString();
        $categories = Expense::$categories;

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = Expense::$categories;
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'category'    => ['required', 'in:' . implode(',', Expense::$categories)],
            'date'        => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense added successfully!');
    }

    public function destroy(Expense $expense)
    {
        // Ensure the expense belongs to the authenticated user
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }
}
