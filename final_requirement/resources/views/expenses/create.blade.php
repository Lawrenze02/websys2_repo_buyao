@extends('layouts.app')

@section('title', 'Add Expense')
@section('page-title', '➕ Add Expense')

@push('styles')
<style>
    .form-card {
        max-width: 680px;
        margin: 0 auto;
    }
    .form-card .card-header {
        padding-bottom: 1rem;
        border-bottom: 1px solid #334155;
        margin-bottom: 1.5rem;
    }
    .amount-input-wrap {
        position: relative;
    }
    .amount-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-weight: 700;
        font-size: 1rem;
    }
    .amount-input-wrap .form-control {
        padding-left: 2.2rem;
        font-size: 1.1rem;
        font-weight: 700;
    }
    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }
    .category-option {
        display: none;
    }
    .category-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 1rem 0.5rem;
        border: 2px solid #334155;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        font-weight: 600;
        color: #94a3b8;
        text-align: center;
    }
    .category-label .cat-icon { font-size: 1.5rem; }
    .category-label:hover {
        border-color: #6366f1;
        color: #f1f5f9;
        background: rgba(99,102,241,0.08);
    }
    .category-option:checked + .category-label {
        border-color: #6366f1;
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
    }
    .form-footer {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid #334155;
    }
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Record a New Expense</div>
                <p style="color:#94a3b8;font-size:0.82rem;margin-top:0.25rem;">Fill in the details below to log your expense.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('expenses.store') }}" id="expenseForm">
            @csrf

            {{-- Amount --}}
            <div class="form-group">
                <label class="form-label" for="amount">Amount</label>
                <div class="amount-input-wrap">
                    <span class="amount-prefix">₱</span>
                    <input
                        type="number"
                        step="0.01"
                        min="0.01"
                        id="amount"
                        name="amount"
                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                        placeholder="0.00"
                        value="{{ old('amount') }}"
                        required
                    >
                </div>
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="form-group">
                <label class="form-label">Category</label>
                <div class="category-grid">
                    @php
                        $catIcons = ['Food' => '🍔', 'Transport' => '🚌', 'Rent' => '🏠'];
                    @endphp
                    @foreach($categories as $cat)
                        <div>
                            <input
                                type="radio"
                                id="cat_{{ $cat }}"
                                name="category"
                                value="{{ $cat }}"
                                class="category-option"
                                {{ old('category') === $cat ? 'checked' : '' }}
                                required
                            >
                            <label class="category-label" for="cat_{{ $cat }}">
                                <span class="cat-icon">{{ $catIcons[$cat] ?? '📌' }}</span>
                                {{ $cat }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date --}}
            <div class="form-group">
                <label class="form-label" for="date">Date</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}"
                    value="{{ old('date', date('Y-m-d')) }}"
                    required
                >
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label" for="description">Description <span style="color:#475569;font-weight:400;">(optional)</span></label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                    placeholder="What was this expense for?"
                    rows="3"
                    style="resize:vertical;"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <a href="{{ route('expenses.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">💾 Save Expense</button>
            </div>
        </form>
    </div>
</div>
@endsection
