@extends('layouts.app')
@section('title','Reports')
@section('page-title','Reports & Analytics')

@section('content')

<form method="GET" action="{{ route('reports.index') }}" class="filters-bar">
  <select class="form-select" name="year" onchange="this.form.submit()" style="width:110px">
    @foreach($years as $y)
      <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
    @endforeach
  </select>
  <select class="form-select" name="month" onchange="this.form.submit()" style="width:130px">
    <option value="0">All Months</option>
    @foreach($months as $num => $name)
      <option value="{{ $num }}" @selected($month == $num)>{{ $name }}</option>
    @endforeach
  </select>
</form>

{{-- Stats --}}
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px">
  <div class="stat-card">
    <div class="stat-icon-wrap red">💸</div>
    <div class="stat-body">
      <div class="stat-label">Total Expense</div>
      <div class="stat-value expense-val">₹{{ number_format($expenses,2) }}</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap green">💰</div>
    <div class="stat-body">
      <div class="stat-label">Total Income</div>
      <div class="stat-value income-val">₹{{ number_format($incomes,2) }}</div>
    </div>
  </div>
  <div class="stat-card">
    @php $net = $incomes - $expenses; @endphp
    <div class="stat-icon-wrap {{ $net >= 0 ? 'blue' : 'amber' }}">⚖️</div>
    <div class="stat-body">
      <div class="stat-label">Net Balance</div>
      <div class="stat-value" style="color:{{ $net >= 0 ? 'var(--income)' : 'var(--expense)' }}">
        {{ $net >= 0 ? '+' : '' }}₹{{ number_format(abs($net),2) }}
      </div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">
  <div>
    {{-- Monthly breakdown --}}
    <div class="card" style="margin-bottom:20px">
      <div class="card-header"><div class="card-title">Monthly Breakdown — {{ $year }}</div></div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Month</th><th>Expense</th><th>Income</th><th>Net</th><th>Savings Rate</th></tr></thead>
          <tbody>
            @foreach($monthly as $m => $data)
            @php $net = $data['income'] - $data['expense']; $rate = $data['income'] > 0 ? round($net/$data['income']*100) : 0; @endphp
            <tr>
              <td style="font-weight:600">{{ $data['label'] }}</td>
              <td class="amount-expense">@if($data['expense'] > 0) ₹{{ number_format($data['expense'],2) }} @else — @endif</td>
              <td class="amount-income">@if($data['income'] > 0) ₹{{ number_format($data['income'],2) }} @else — @endif</td>
              <td style="font-weight:700;color:{{ $net >= 0 ? 'var(--income)' : 'var(--expense)' }}">
                @if($data['expense'] > 0 || $data['income'] > 0) {{ $net >= 0 ? '+' : '' }}₹{{ number_format(abs($net),2) }} @else — @endif
              </td>
              <td>
                @if($data['income'] > 0)
                  <div style="display:flex;align-items:center;gap:8px;min-width:100px">
                    <div class="progress" style="flex:1">
                      <div class="progress-bar {{ $rate >= 20 ? 'prog-green' : ($rate >= 0 ? 'prog-amber' : 'prog-red') }}" style="width:{{ max(0,min(100,$rate)) }}%"></div>
                    </div>
                    <span style="font-size:12px;color:var(--muted);width:34px">{{ $rate }}%</span>
                  </div>
                @else — @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Payment method breakdown --}}
    @if($byPayment->count())
    <div class="card">
      <div class="card-header"><div class="card-title">Expense by Payment Method</div></div>
      <div class="card-body">
        @php $pmMax = $byPayment->max('total') ?: 1; @endphp
        @foreach($byPayment as $pm)
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px">
            <span style="font-weight:600">{{ $pm->payment_method }}</span>
            <span class="amount-expense">₹{{ number_format($pm->total,2) }}</span>
          </div>
          <div class="progress">
            <div class="progress-bar prog-blue" style="width:{{ round($pm->total/$pmMax*100) }}%"></div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  {{-- Category breakdown --}}
  <div>
    <div class="card">
      <div class="card-header"><div class="card-title">Expense by Category</div></div>
      @if($byCategory->isEmpty())
        <div class="empty-state" style="padding:30px"><p>No expense data for this period.</p></div>
      @else
      @php $catMax = $byCategory->max('total') ?: 1; @endphp
      <div class="card-body" style="padding:12px 16px">
        @foreach($byCategory as $cat)
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px">
            <span style="display:flex;align-items:center;gap:6px;font-weight:600">
              <span>{{ $cat->icon }}</span>{{ e($cat->name) }}
            </span>
            <span class="amount-expense">₹{{ number_format($cat->total,2) }}</span>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width:{{ round($cat->total/$catMax*100) }}%;background:{{ $cat->color }}"></div>
          </div>
          <div style="font-size:11px;color:var(--muted);margin-top:3px;text-align:right">
            {{ $expenses > 0 ? round($cat->total/$expenses*100) : 0 }}% of total
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
