@extends('layouts.app')
@section('title','Transactions')
@section('page-title','Transactions')

@section('topbar-actions')
<a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
  Add Transaction
</a>
@endsection

@section('content')

<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon-wrap red">💸</div>
    <div class="stat-body">
      <div class="stat-label">This Month Expense</div>
      <div class="stat-value expense-val">₹{{ number_format($totalExpense,2) }}</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap green">💰</div>
    <div class="stat-body">
      <div class="stat-label">This Month Income</div>
      <div class="stat-value income-val">₹{{ number_format($totalIncome,2) }}</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap {{ $balance >= 0 ? 'blue' : 'amber' }}">⚖️</div>
    <div class="stat-body">
      <div class="stat-label">Net Balance</div>
      <div class="stat-value" style="color:{{ $balance >= 0 ? 'var(--income)' : 'var(--expense)' }}">
        {{ $balance >= 0 ? '+' : '' }}₹{{ number_format(abs($balance),2) }}
      </div>
    </div>
  </div>
</div>

<form method="GET" action="{{ route('expenses.index') }}" class="filters-bar">
  <div class="search-bar">
    <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input class="form-control" type="search" name="search" value="{{ request('search') }}" placeholder="Search transactions…">
  </div>
  <select class="form-select" name="type" onchange="this.form.submit()" style="width:120px">
    <option value="">All Types</option>
    <option value="expense" @selected(request('type')==='expense')>Expense</option>
    <option value="income"  @selected(request('type')==='income')>Income</option>
  </select>
  <select class="form-select" name="category" onchange="this.form.submit()" style="width:150px">
    <option value="">All Categories</option>
    @foreach($categories as $cat)
      <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
    @endforeach
  </select>
  <select class="form-select" name="payment_method" onchange="this.form.submit()" style="width:140px">
    <option value="">All Methods</option>
    @foreach($paymentMethods as $pm)
      <option value="{{ $pm }}" @selected(request('payment_method')===$pm)>{{ $pm }}</option>
    @endforeach
  </select>
  <input class="form-control" type="date" name="date_from" value="{{ request('date_from') }}" style="width:150px" onchange="this.form.submit()">
  <input class="form-control" type="date" name="date_to"   value="{{ request('date_to') }}"   style="width:150px" onchange="this.form.submit()">
  <button class="btn btn-outline btn-sm" type="submit">Filter</button>
  @if(request()->anyFilled(['search','type','category','payment_method','date_from','date_to']))
    <a href="{{ route('expenses.index') }}" class="btn btn-ghost btn-sm">Clear</a>
  @endif
</form>

<div class="card">
  <div class="card-header">
    <div class="card-title">All Transactions
      <span style="font-size:12px;font-weight:400;color:var(--muted);margin-left:8px">{{ $expenses->total() }} records</span>
    </div>
  </div>
  <div class="table-wrap">
    @if($expenses->isEmpty())
      <div class="empty-state">
        <div class="empty-state-icon">💸</div>
        <h3>No transactions found</h3>
        <p><a href="{{ route('expenses.create') }}" style="color:var(--primary)">Add your first transaction</a></p>
      </div>
    @else
    <table>
      <thead>
        <tr>
          <th>Title</th><th>Type</th><th>Category</th>
          <th>Date</th><th>Method</th><th>Amount</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($expenses as $exp)
        <tr>
          <td>
            <div style="font-weight:600">{{ e($exp->title) }}</div>
            @if($exp->description)<div style="font-size:12px;color:var(--muted)">{{ Str::limit($exp->description,45) }}</div>@endif
            @if($exp->is_recurring)<span class="badge badge-blue" style="font-size:10px;margin-top:3px">🔄 Recurring</span>@endif
          </td>
          <td><span class="badge badge-{{ $exp->type === 'income' ? 'income' : 'expense' }}">{{ ucfirst($exp->type) }}</span></td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <span>{{ $exp->category?->icon }}</span>
              <span style="font-size:13px">{{ $exp->category?->name }}</span>
            </div>
          </td>
          <td style="color:var(--muted);font-size:13px;white-space:nowrap">{{ $exp->date->format('d M Y') }}</td>
          <td><span class="badge badge-gray">{{ $exp->payment_method }}</span></td>
          <td style="white-space:nowrap">
            <span class="{{ $exp->type === 'income' ? 'amount-income' : 'amount-expense' }}">
              {{ $exp->type === 'income' ? '+' : '-' }}₹{{ number_format($exp->amount,2) }}
            </span>
          </td>
          <td>
            <div class="action-strip">
              <a href="{{ route('expenses.show', $exp) }}" class="btn-icon" title="View">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              <a href="{{ route('expenses.edit', $exp) }}" class="btn-icon" title="Edit">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </a>
              <form method="POST" action="{{ route('expenses.destroy', $exp) }}" id="del-{{ $exp->id }}">
                @csrf @method('DELETE')
                <button type="button" class="btn-icon danger" onclick="confirmDelete(document.getElementById('del-{{ $exp->id }}'),'{{ e($exp->title) }}')">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    @if($expenses->hasPages())
    <div class="pagination-wrap">
      <div class="pagination-info">Showing {{ $expenses->firstItem() }}–{{ $expenses->lastItem() }} of {{ $expenses->total() }}</div>
      <div class="pagination-links">
        @if($expenses->onFirstPage())
          <span class="page-link disabled">‹</span>
        @else
          <a class="page-link" href="{{ $expenses->previousPageUrl() }}">‹</a>
        @endif
        @foreach($expenses->getUrlRange(max(1,$expenses->currentPage()-2), min($expenses->lastPage(),$expenses->currentPage()+2)) as $page => $url)
          <a class="page-link {{ $page == $expenses->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
        @endforeach
        @if($expenses->hasMorePages())
          <a class="page-link" href="{{ $expenses->nextPageUrl() }}">›</a>
        @else
          <span class="page-link disabled">›</span>
        @endif
      </div>
    </div>
    @endif
    @endif
  </div>
</div>
@endsection
