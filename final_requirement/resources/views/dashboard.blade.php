@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', '📊 Dashboard')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .budget-bar-wrap {
        margin-top: 1rem;
    }
    .budget-bar-track {
        background: #334155;
        border-radius: 999px;
        height: 10px;
        overflow: hidden;
        margin: 0.5rem 0;
    }
    .budget-bar-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 1s ease;
    }
    .recent-table td:first-child { font-weight: 600; color: #f1f5f9; }
    .amount-cell { font-weight: 700; font-size: 1rem; color: #a5b4fc; }
    .no-data {
        text-align: center;
        padding: 3rem;
        color: #64748b;
    }
    .no-data .no-data-icon { font-size: 3rem; margin-bottom: 0.75rem; }
    .welcome-banner {
        background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(79,70,229,0.1));
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .welcome-text h2 { font-size: 1.3rem; font-weight: 800; margin-bottom: 0.25rem; }
    .welcome-text p  { color: #94a3b8; font-size: 0.875rem; }
    .welcome-emoji { font-size: 3rem; }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
        <p>Here's your financial snapshot for {{ now()->format('F Y') }}</p>
    </div>
    <div class="welcome-emoji">💰</div>
</div>

{{-- Over-budget alert --}}
@if($overBudget)
<div class="alert alert-danger" style="font-size:0.9rem;">
    ⚠️ <strong>Budget Exceeded!</strong>
    You've spent <strong>₱{{ number_format($totalThisMonth, 2) }}</strong>
    of your ₱{{ number_format($monthlyLimit, 2) }} budget this month.
    You are <strong>₱{{ number_format($totalThisMonth - $monthlyLimit, 2) }}</strong> over!
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-4" style="margin-bottom:1.5rem;">
    <div class="stat-card indigo">
        <div class="stat-icon">💸</div>
        <div class="stat-label">Total This Month</div>
        <div class="stat-value" style="color:#a5b4fc;">₱{{ number_format($totalThisMonth, 2) }}</div>
        <div class="stat-sub">{{ now()->format('F Y') }}</div>
    </div>

    <div class="stat-card {{ $overBudget ? 'red' : 'green' }}">
        <div class="stat-icon">🎯</div>
        <div class="stat-label">Monthly Budget</div>
        <div class="stat-value" style="color:{{ $monthlyLimit ? '#6ee7b7' : '#94a3b8' }};">
            {{ $monthlyLimit ? '₱'.number_format($monthlyLimit, 2) : '—' }}
        </div>
        <div class="stat-sub">{{ $monthlyLimit ? 'Limit set' : 'No budget set yet' }}</div>
    </div>

    <div class="stat-card {{ ($remaining !== null && $remaining < 0) ? 'red' : 'amber' }}">
        <div class="stat-icon">{{ ($remaining !== null && $remaining < 0) ? '🔴' : '📉' }}</div>
        <div class="stat-label">Remaining Budget</div>
        <div class="stat-value" style="color:{{ ($remaining !== null && $remaining < 0) ? '#fca5a5' : '#fcd34d' }};">
            @if($remaining !== null)
                ₱{{ number_format(abs($remaining), 2) }}{{ $remaining < 0 ? ' over' : '' }}
            @else
                —
            @endif
        </div>
        <div class="stat-sub">{{ $remaining !== null ? 'After expenses' : 'Set a budget first' }}</div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Categories Used</div>
        <div class="stat-value" style="color:#a5b4fc;">{{ count($byCategory) }}</div>
        <div class="stat-sub">This month</div>
    </div>
</div>

{{-- Budget Progress Bar --}}
@if($monthlyLimit && $totalThisMonth > 0)
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header">
        <span class="card-title">📈 Budget Usage</span>
        <span style="color:#94a3b8;font-size:0.8rem;">
            ₱{{ number_format($totalThisMonth,2) }} / ₱{{ number_format($monthlyLimit,2) }}
        </span>
    </div>
    @php
        $pct = min(round(($totalThisMonth / $monthlyLimit) * 100), 100);
        $barColor = $overBudget ? '#ef4444' : ($pct > 75 ? '#f59e0b' : '#10b981');
    @endphp
    <div class="budget-bar-wrap">
        <div class="budget-bar-track">
            <div class="budget-bar-fill" style="width:{{ $pct }}%; background:{{ $barColor }};"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.78rem;color:#94a3b8;margin-top:0.25rem;">
            <span>{{ $pct }}% used</span>
            <span>{{ 100 - $pct < 0 ? 0 : 100 - $pct }}% remaining</span>
        </div>
    </div>
</div>
@endif

{{-- Chart + Recent Expenses --}}
<div class="grid grid-2" style="align-items:start;">

    {{-- Chart --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">🍩 Spending by Category</span>
            <span style="color:#94a3b8;font-size:0.78rem;">{{ now()->format('F Y') }}</span>
        </div>
        @if(count($byCategory) > 0)
            <div class="chart-container">
                <canvas id="categoryChart"></canvas>
            </div>
        @else
            <div class="no-data">
                <div class="no-data-icon">📭</div>
                <p>No expenses this month yet.</p>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary" style="margin-top:1rem;">Add Your First Expense</a>
            </div>
        @endif
    </div>

    {{-- Recent Expenses --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">🕒 Recent Expenses</span>
            <a href="{{ route('expenses.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        @if($recentExpenses->isNotEmpty())
            <div class="table-wrap">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentExpenses as $exp)
                        <tr>
                            <td>
                                <span class="badge badge-{{ strtolower($exp->category) }}">{{ $exp->category }}</span>
                                @if($exp->description)
                                    <div style="font-size:0.72rem;color:#64748b;margin-top:3px;">{{ Str::limit($exp->description, 30) }}</div>
                                @endif
                            </td>
                            <td style="color:#94a3b8;font-size:0.8rem;">{{ $exp->date->format('M d, Y') }}</td>
                            <td class="amount-cell">₱{{ number_format($exp->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <div class="no-data-icon">📭</div>
                <p>No expenses recorded yet.</p>
            </div>
        @endif
    </div>
</div>

{{-- Quick Action Buttons --}}
<div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
    <a href="{{ route('expenses.create') }}" class="btn btn-primary">➕ Add Expense</a>
    <a href="{{ route('expenses.index') }}" class="btn btn-outline">📋 Expense History</a>
    <a href="{{ route('budgets.index') }}" class="btn btn-outline">🎯 Set Budget</a>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('categoryChart');
    if (!ctx) return;

    const data = @json($byCategory);
    const labels = Object.keys(data);
    const values = Object.values(data);

    const colorMap = {
        'Food':      ['rgba(236,72,153,0.8)', 'rgba(236,72,153,0.3)'],
        'Transport': ['rgba(59,130,246,0.8)',  'rgba(59,130,246,0.3)'],
        'Rent':      ['rgba(245,158,11,0.8)',  'rgba(245,158,11,0.3)'],
    };

    const bgColors  = labels.map(l => colorMap[l] ? colorMap[l][0] : 'rgba(148,163,184,0.8)');
    const bdColors  = labels.map(l => colorMap[l] ? colorMap[l][1] : 'rgba(148,163,184,0.3)');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: bgColors,
                borderColor: bdColors,
                borderWidth: 2,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#94a3b8',
                        padding: 16,
                        font: { size: 12, family: 'Inter' },
                        usePointStyle: true,
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ₱${parseFloat(ctx.raw).toFixed(2)}`
                    }
                }
            }
        }
    });
});
</script>
@endpush
