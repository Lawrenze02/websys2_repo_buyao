@extends('layouts.app')

@section('title', 'Budget Goals')
@section('page-title', '🎯 Budget Goals')

@push('styles')
<style>
    .budget-form-card { max-width: 560px; }
    .month-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    .budget-history table th  { font-size: 0.72rem; }
    .month-badge {
        background: rgba(99,102,241,0.1);
        border: 1px solid rgba(99,102,241,0.2);
        color: #a5b4fc;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .current-badge {
        background: rgba(16,185,129,0.1);
        border: 1px solid rgba(16,185,129,0.2);
        color: #6ee7b7;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    .limit-value { font-weight: 700; color: #fcd34d; }
</style>
@endpush

@section('content')

<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:1.5rem;align-items:start;">

    {{-- ── Set Budget Form ── --}}
    <div class="card budget-form-card">
        <div class="card-header" style="border-bottom:1px solid #334155;padding-bottom:1rem;margin-bottom:1.5rem;">
            <div>
                <div class="card-title">Set Monthly Budget</div>
                <p style="color:#94a3b8;font-size:0.82rem;margin-top:0.25rem;">
                    Define spending limits for any month.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('budgets.store') }}">
            @csrf

            {{-- Monthly Limit --}}
            <div class="form-group">
                <label class="form-label" for="monthly_limit">Monthly Limit (₱)</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-weight:700;">₱</span>
                    <input
                        type="number"
                        id="monthly_limit"
                        name="monthly_limit"
                        step="0.01"
                        min="1"
                        class="form-control {{ $errors->has('monthly_limit') ? 'is-invalid' : '' }}"
                        style="padding-left:2.2rem;font-size:1.1rem;font-weight:700;"
                        placeholder="0.00"
                        value="{{ old('monthly_limit', $budget?->monthly_limit) }}"
                        required
                    >
                </div>
                @error('monthly_limit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Month & Year --}}
            <div class="month-selector">
                <div class="form-group">
                    <label class="form-label" for="month">Month</label>
                    <select id="month" name="month" class="form-select {{ $errors->has('month') ? 'is-invalid' : '' }}" required>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ (int)old('month', $month) === $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                    @error('month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="year">Year</label>
                    <select id="year" name="year" class="form-select {{ $errors->has('year') ? 'is-invalid' : '' }}" required>
                        @foreach(range(now()->year - 1, now()->year + 2) as $y)
                            <option value="{{ $y }}" {{ (int)old('year', $year) === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:10px;padding:0.85rem 1rem;margin-bottom:1.25rem;font-size:0.82rem;color:#94a3b8;">
                💡 <strong style="color:#a5b4fc;">Tip:</strong> If a budget for that month already exists, it will be updated automatically.
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                💾 Save Budget
            </button>
        </form>
    </div>

    {{-- ── Budget History ── --}}
    <div class="card budget-history">
        <div class="card-header">
            <span class="card-title">📅 Budget History</span>
            <span style="color:#64748b;font-size:0.8rem;">{{ $allBudgets->count() }} record(s)</span>
        </div>

        @if($allBudgets->isNotEmpty())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Monthly Limit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allBudgets as $b)
                    <tr>
                        <td>
                            <span class="month-badge">
                                {{ DateTime::createFromFormat('!m', $b->month)->format('F') }} {{ $b->year }}
                            </span>
                            @if($b->month === $month && $b->year === $year)
                                <span class="current-badge">Current</span>
                            @endif
                        </td>
                        <td class="limit-value">₱{{ number_format($b->monthly_limit, 2) }}</td>
                        <td>
                            <form
                                method="POST"
                                action="{{ route('budgets.destroy', $b->id) }}"
                                onsubmit="return confirm('Remove budget for {{ DateTime::createFromFormat('!m', $b->month)->format('F Y') }}?')"
                                style="display:inline;"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:3rem 1rem;color:#64748b;">
            <div style="font-size:3rem;margin-bottom:0.75rem;">🎯</div>
            <p>No budgets set yet.</p>
            <p style="font-size:0.82rem;margin-top:0.35rem;">Set your first monthly limit using the form on the left.</p>
        </div>
        @endif
    </div>

</div>
@endsection
