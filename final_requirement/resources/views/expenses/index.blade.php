@extends('layouts.app')

@section('title', 'Expense History')
@section('page-title', '📋 Expense History')

@push('styles')
<style>
    .filter-card {
        margin-bottom: 1.25rem;
    }
    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr auto;
        gap: 0.75rem;
        align-items: end;
    }
    @media (max-width: 900px) {
        .filter-row { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .filter-row { grid-template-columns: 1fr; }
    }
    .filter-row .form-group { margin-bottom: 0; }
    .amount-positive { color: #fca5a5; font-weight: 700; }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }
    .empty-state .icon { font-size: 3.5rem; margin-bottom: 1rem; }
    .empty-state h3 { color: #94a3b8; margin-bottom: 0.5rem; font-size: 1.1rem; }
    .table-summary {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .summary-chip {
        background: rgba(99,102,241,0.1);
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 999px;
        padding: 0.35rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #a5b4fc;
    }
    .delete-form { display: inline; }
</style>
@endpush

@section('content')

{{-- Filter Card --}}
<div class="card filter-card">
    <form method="GET" action="{{ route('expenses.index') }}" id="filterForm">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Search Description</label>
                <input type="text" name="search" class="form-control" placeholder="Search…" value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">From Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label class="form-label">To Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="form-group" style="display:flex;gap:0.5rem;">
                <button type="submit" class="btn btn-primary" style="white-space:nowrap;">🔍 Filter</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline" title="Clear filters">✕</a>
            </div>
        </div>
    </form>
</div>

{{-- Summary Row --}}
<div class="table-summary">
    <span class="summary-chip">
        📦 {{ $expenses->total() }} record{{ $expenses->total() !== 1 ? 's' : '' }}
    </span>
    <span class="summary-chip">
        💸 Total: ₱{{ number_format($expenses->getCollection()->sum('amount'), 2) }} (this page)
    </span>
    @if(request()->hasAny(['search','category','start_date','end_date']))
    <span class="summary-chip" style="background:rgba(245,158,11,0.1);border-color:rgba(245,158,11,0.2);color:#fcd34d;">
        🔎 Filters active
    </span>
    @endif
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">All Expenses</span>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">➕ Add New</a>
    </div>

    @if($expenses->isNotEmpty())
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $index => $expense)
                <tr id="expense-row-{{ $expense->id }}">
                    <td style="color:#64748b;font-size:0.8rem;">
                        {{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}
                    </td>
                    <td style="color:#94a3b8;font-size:0.85rem;white-space:nowrap;">
                        {{ $expense->date->format('M d, Y') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ strtolower($expense->category) }}">
                            {{ $expense->category }}
                        </span>
                    </td>
                    <td style="max-width:250px;color:#94a3b8;font-size:0.875rem;">
                        {{ $expense->description ?: '—' }}
                    </td>
                    <td class="amount-positive">₱{{ number_format($expense->amount, 2) }}</td>
                    <td>
                        <form
                            class="delete-form"
                            method="POST"
                            action="{{ route('expenses.destroy', $expense->id) }}"
                            onsubmit="return confirmDelete(event, '{{ number_format($expense->amount,2) }}', '{{ $expense->category }}')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete expense">
                                🗑 Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($expenses->hasPages())
    <div class="pagination-wrap">
        {{-- Previous --}}
        @if($expenses->onFirstPage())
            <span class="disabled">‹</span>
        @else
            <a href="{{ $expenses->previousPageUrl() }}">‹</a>
        @endif

        {{-- Pages --}}
        @foreach($expenses->getUrlRange(1, $expenses->lastPage()) as $page => $url)
            @if($page == $expenses->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($expenses->hasMorePages())
            <a href="{{ $expenses->nextPageUrl() }}">›</a>
        @else
            <span class="disabled">›</span>
        @endif
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="icon">📭</div>
        <h3>No expenses found</h3>
        <p>
            @if(request()->hasAny(['search','category','start_date','end_date']))
                Try adjusting your filters.
                <a href="{{ route('expenses.index') }}" style="color:#6366f1;">Clear all filters</a>
            @else
                You haven't recorded any expenses yet.
            @endif
        </p>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary" style="margin-top:1.25rem;">➕ Add First Expense</a>
    </div>
    @endif
</div>

{{-- Delete Confirmation Modal (CSS-only) --}}
<div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#1e293b;border:1px solid #334155;border-radius:16px;padding:2rem;max-width:420px;width:90%;text-align:center;">
        <div style="font-size:2.5rem;margin-bottom:1rem;">⚠️</div>
        <h3 style="margin-bottom:0.5rem;">Delete Expense?</h3>
        <p id="deleteModalMsg" style="color:#94a3b8;font-size:0.875rem;margin-bottom:1.5rem;"></p>
        <div style="display:flex;gap:0.75rem;justify-content:center;">
            <button onclick="cancelDelete()" class="btn btn-outline">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let pendingForm = null;

function confirmDelete(event, amount, category) {
    event.preventDefault();
    pendingForm = event.target;
    document.getElementById('deleteModalMsg').textContent =
        `Are you sure you want to delete this ₱${amount} ${category} expense? This cannot be undone.`;
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
    return false;
}

function cancelDelete() {
    document.getElementById('deleteModal').style.display = 'none';
    pendingForm = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (pendingForm) {
        document.getElementById('deleteModal').style.display = 'none';
        pendingForm.submit();
    }
});

// Close modal on backdrop click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) cancelDelete();
});
</script>
@endpush
