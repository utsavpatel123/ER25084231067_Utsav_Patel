@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('topbar-actions')
<a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
  Add Transaction
</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon-wrap red">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    </div>
    <div class="stat-body">
      <div class="stat-label">This Month Expense</div>
      <div class="stat-value expense-val">₹{{ number_format($monthExpense,2) }}</div>
      <div class="stat-sub">Total spending</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap green">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
    </div>
    <div class="stat-body">
      <div class="stat-label">This Month Income</div>
      <div class="stat-value income-val">₹{{ number_format($monthIncome,2) }}</div>
      <div class="stat-sub">Total earnings</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap {{ $monthBalance >= 0 ? 'blue' : 'amber' }}">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
    </div>
    <div class="stat-body">
      <div class="stat-label">Net Balance</div>
      <div class="stat-value" style="color:{{ $monthBalance >= 0 ? 'var(--income)' : 'var(--expense)' }}">
        {{ $monthBalance >= 0 ? '+' : '' }}₹{{ number_format(abs($monthBalance),2) }}
      </div>
      <div class="stat-sub">Income minus expenses</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap teal">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </div>
    <div class="stat-body">
      <div class="stat-label">This Year Expense</div>
      <div class="stat-value">₹{{ number_format($yearExpense,2) }}</div>
      <div class="stat-sub">Year {{ now()->year }}</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">
  <div>

    {{-- Recent Transactions --}}
    <div class="card">
      <div class="card-header">
        <div class="card-title">Recent Transactions</div>
        <a href="{{ route('expenses.index') }}" class="btn btn-ghost btn-sm">View All →</a>
      </div>
      <div class="table-wrap">
        @if($recent->isEmpty())
          <div class="empty-state">
            <div class="empty-state-icon">💸</div>
            <h3>No transactions yet</h3>
            <p><a href="{{ route('expenses.create') }}" style="color:var(--primary)">Add your first transaction</a></p>
          </div>
        @else
        <table>
          <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Method</th><th>Amount</th><th></th></tr></thead>
          <tbody>
            @foreach($recent as $exp)
            <tr>
              <td>
                <div style="font-weight:600">{{ e($exp->title) }}</div>
                @if($exp->description)<div style="font-size:12px;color:var(--muted)">{{ Str::limit($exp->description,40) }}</div>@endif
              </td>
              <td>
                <div style="display:flex;align-items:center;gap:6px">
                  <span style="font-size:16px">{{ $exp->category?->icon }}</span>
                  <span style="font-size:13px;color:var(--text2)">{{ $exp->category?->name }}</span>
                </div>
              </td>
              <td style="color:var(--muted);font-size:13px">{{ $exp->date->format('d M Y') }}</td>
              <td><span class="badge badge-gray">{{ $exp->payment_method }}</span></td>
              <td>
                <span class="{{ $exp->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                  {{ $exp->type === 'income' ? '+' : '-' }}₹{{ number_format($exp->amount,2) }}
                </span>
              </td>
              <td>
                <a href="{{ route('expenses.show', $exp) }}" class="btn-icon" title="View">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>

    {{-- 6-month trend --}}
    @if(count($trend))
    <div class="card">
      <div class="card-header"><div class="card-title">6-Month Trend</div></div>
      <div class="card-body">
        <div style="display:flex;flex-direction:column;gap:10px">
          @foreach($trend as $t)
          @php $max = max(array_column($trend,'expense') + array_column($trend,'income')) ?: 1; @endphp
          <div>
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px">
              <span style="font-weight:600;color:var(--text2)">{{ $t['month'] }}</span>
              <span>
                <span class="amount-income">+₹{{ number_format($t['income'],0) }}</span>
                &nbsp;
                <span class="amount-expense">-₹{{ number_format($t['expense'],0) }}</span>
              </span>
            </div>
            <div style="display:flex;gap:4px">
              <div class="progress" style="flex:1">
                <div class="progress-bar prog-green" style="width:{{ $max > 0 ? round($t['income']/$max*100) : 0 }}%"></div>
              </div>
            </div>
            <div class="progress" style="margin-top:3px">
              <div class="progress-bar prog-red" style="width:{{ $max > 0 ? round($t['expense']/$max*100) : 0 }}%"></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

  </div>

  <div>
    {{-- Budgets --}}
    @if($budgets->count())
    <div class="card" style="margin-bottom:16px">
      <div class="card-header">
        <div class="card-title">Budget Status</div>
        <a href="{{ route('budgets.index') }}" class="btn btn-ghost btn-sm">All →</a>
      </div>
      <div class="card-body" style="padding:12px 16px">
        @foreach($budgets as $b)
        @php
          $pct = $b->percent_used;
          $barClass = $pct >= 100 ? 'prog-red' : ($pct >= 80 ? 'prog-amber' : 'prog-green');
        @endphp
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px">
            <span style="font-weight:600;display:flex;align-items:center;gap:5px">
              <span>{{ $b->category?->icon }}</span>
              {{ e($b->name) }}
            </span>
            <span style="color:var(--muted)">₹{{ number_format($b->spent,0) }} / ₹{{ number_format($b->amount,0) }}</span>
          </div>
          <div class="progress">
            <div class="progress-bar {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
          <div style="font-size:11px;color:var(--muted);margin-top:3px;text-align:right">{{ $pct }}% used</div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Top Categories --}}
    @if($topCategories->count())
    <div class="card">
      <div class="card-header"><div class="card-title">Top Expense Categories</div></div>
      <div class="card-body" style="padding:12px 16px">
        @php $catMax = $topCategories->max('month_total') ?: 1; @endphp
        @foreach($topCategories as $cat)
        <div style="margin-bottom:12px">
          <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
            <span style="display:flex;align-items:center;gap:6px;font-weight:600">
              <span>{{ $cat->icon }}</span>{{ e($cat->name) }}
            </span>
            <span class="amount-expense">₹{{ number_format($cat->month_total,0) }}</span>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width:{{ round($cat->month_total/$catMax*100) }}%;background:{{ $cat->color }}"></div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
