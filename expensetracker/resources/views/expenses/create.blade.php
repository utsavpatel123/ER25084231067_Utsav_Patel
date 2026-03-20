@extends('layouts.app')
@section('title','Add Transaction')
@section('page-title','Add Transaction')
@section('topbar-actions')
<a href="{{ route('expenses.index') }}" class="btn btn-outline btn-sm">← Back</a>
@endsection

@section('content')
<nav class="breadcrumb">
  <a href="{{ route('expenses.index') }}">Transactions</a><span>›</span><span>Add New</span>
</nav>

<form method="POST" action="{{ route('expenses.store') }}" novalidate>
@csrf
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
  <div>
    {{-- Type Toggle --}}
    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Type</div></div>
      <div class="card-body">
        <div class="type-toggle">
          <input type="radio" name="type" id="type_expense" value="expense" {{ old('type','expense') === 'expense' ? 'checked' : '' }}>
          <label for="type_expense" class="toggle-expense">💸 Expense</label>
          <input type="radio" name="type" id="type_income" value="income" {{ old('type') === 'income' ? 'checked' : '' }}>
          <label for="type_income" class="toggle-income">💰 Income</label>
        </div>
        @error('type')<div class="form-error">{{ $message }}</div>@enderror
      </div>
    </div>

    {{-- Details --}}
    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Details</div></div>
      <div class="card-body">
        <div class="form-grid">
          <div class="form-group full">
            <label class="form-label">Title <span class="req">*</span></label>
            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Grocery Shopping" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Amount (₹) <span class="req">*</span></label>
            <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" value="{{ old('amount') }}" placeholder="0.00" step="0.01" min="0.01" required>
            @error('amount')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Date <span class="req">*</span></label>
            <input class="form-control @error('date') is-invalid @enderror" type="date" name="date" value="{{ old('date', now()->toDateString()) }}" max="{{ now()->toDateString() }}" required>
            @error('date')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Category <span class="req">*</span></label>
            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
              <option value="" disabled @selected(!old('category_id'))>Select category…</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
              @endforeach
            </select>
            @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Payment Method <span class="req">*</span></label>
            <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" required>
              @foreach($paymentMethods as $pm)
                <option value="{{ $pm }}" @selected(old('payment_method','Cash') === $pm)>{{ $pm }}</option>
              @endforeach
            </select>
            @error('payment_method')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Reference / Invoice No</label>
            <input class="form-control" type="text" name="reference" value="{{ old('reference') }}" placeholder="Optional">
          </div>
          <div class="form-group full">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2" placeholder="Optional notes…">{{ old('description') }}</textarea>
          </div>
          <div class="form-group full">
            <label class="form-label">Tags</label>
            <input class="form-control" type="text" name="tags" value="{{ old('tags') }}" placeholder="Comma separated: food, monthly, work">
            <div class="form-hint">Separate tags with commas</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Recurring --}}
    <div class="card">
      <div class="card-header"><div class="card-title">Recurring</div></div>
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
          <input type="checkbox" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--primary)">
          <label for="is_recurring" style="font-size:13.5px;font-weight:600;cursor:pointer">This is a recurring transaction</label>
        </div>
        <div id="recurring_period_wrap" style="display:none">
          <div class="form-group">
            <label class="form-label">Recurring Period</label>
            <select class="form-select @error('recurring_period') is-invalid @enderror" name="recurring_period">
              <option value="">Select period…</option>
              @foreach(['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly'] as $val => $lbl)
                <option value="{{ $val }}" @selected(old('recurring_period') === $val)>{{ $lbl }}</option>
              @endforeach
            </select>
            @error('recurring_period')<div class="form-error">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  <div>
    <div class="card">
      <div class="card-body">
        <p style="font-size:12.5px;color:var(--muted);line-height:1.6;margin-bottom:16px">
          Fill in all required fields marked with <span class="req">*</span> and click Save.
        </p>
        <button type="submit" class="btn btn-primary" style="width:100%">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Save Transaction
        </button>
        <a href="{{ route('expenses.index') }}" class="btn btn-outline" style="width:100%;margin-top:8px;justify-content:center">Cancel</a>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
