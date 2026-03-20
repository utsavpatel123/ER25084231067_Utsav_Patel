@extends('layouts.app')
@section('title','Edit Transaction')
@section('page-title','Edit Transaction')
@section('topbar-actions')
<a href="{{ route('expenses.show', $expense) }}" class="btn btn-outline btn-sm">← Cancel</a>
@endsection

@section('content')
<nav class="breadcrumb">
  <a href="{{ route('expenses.index') }}">Transactions</a><span>›</span>
  <a href="{{ route('expenses.show', $expense) }}">{{ e($expense->title) }}</a>
  <span>›</span><span>Edit</span>
</nav>

<form method="POST" action="{{ route('expenses.update', $expense) }}" novalidate>
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
  <div>
    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Type</div></div>
      <div class="card-body">
        <div class="type-toggle">
          <input type="radio" name="type" id="type_expense" value="expense" {{ old('type',$expense->type) === 'expense' ? 'checked' : '' }}>
          <label for="type_expense" class="toggle-expense">💸 Expense</label>
          <input type="radio" name="type" id="type_income" value="income" {{ old('type',$expense->type) === 'income' ? 'checked' : '' }}>
          <label for="type_income" class="toggle-income">💰 Income</label>
        </div>
        @error('type')<div class="form-error">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Details</div></div>
      <div class="card-body">
        <div class="form-grid">
          <div class="form-group full">
            <label class="form-label">Title <span class="req">*</span></label>
            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title',$expense->title) }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Amount (₹) <span class="req">*</span></label>
            <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" value="{{ old('amount',$expense->amount) }}" step="0.01" min="0.01" required>
            @error('amount')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Date <span class="req">*</span></label>
            <input class="form-control @error('date') is-invalid @enderror" type="date" name="date" value="{{ old('date',$expense->date->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" required>
            @error('date')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Category <span class="req">*</span></label>
            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id',$expense->category_id) == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
              @endforeach
            </select>
            @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Payment Method <span class="req">*</span></label>
            <select class="form-select" name="payment_method" required>
              @foreach($paymentMethods as $pm)
                <option value="{{ $pm }}" @selected(old('payment_method',$expense->payment_method) === $pm)>{{ $pm }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Reference</label>
            <input class="form-control" type="text" name="reference" value="{{ old('reference',$expense->reference) }}">
          </div>
          <div class="form-group full">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2">{{ old('description',$expense->description) }}</textarea>
          </div>
          <div class="form-group full">
            <label class="form-label">Tags</label>
            <input class="form-control" type="text" name="tags" value="{{ old('tags',$expense->tags) }}" placeholder="Comma separated">
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><div class="card-title">Recurring</div></div>
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
          <input type="checkbox" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring',$expense->is_recurring) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--primary)">
          <label for="is_recurring" style="font-size:13.5px;font-weight:600;cursor:pointer">Recurring transaction</label>
        </div>
        <div id="recurring_period_wrap">
          <div class="form-group">
            <label class="form-label">Recurring Period</label>
            <select class="form-select" name="recurring_period">
              <option value="">Select…</option>
              @foreach(['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly'] as $val => $lbl)
                <option value="{{ $val }}" @selected(old('recurring_period',$expense->recurring_period) === $val)>{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:14px">
      <div class="card-body">
        <div style="font-size:12.5px;color:var(--muted);line-height:1.8">
          <div><strong style="color:var(--text2)">Created:</strong> {{ $expense->created_at->format('d M Y, h:i A') }}</div>
          <div><strong style="color:var(--text2)">Updated:</strong> {{ $expense->updated_at->diffForHumans() }}</div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <button type="submit" class="btn btn-primary" style="width:100%">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Save Changes
        </button>
        <a href="{{ route('expenses.show', $expense) }}" class="btn btn-outline" style="width:100%;margin-top:8px;justify-content:center">Cancel</a>
        <hr style="border:none;border-top:1px solid var(--border);margin:14px 0">
        <form method="POST" action="{{ route('expenses.destroy', $expense) }}" id="del-form">
          @csrf @method('DELETE')
          <button type="button" class="btn btn-ghost" style="width:100%;color:var(--danger);justify-content:center"
            onclick="confirmDelete(document.getElementById('del-form'),'{{ e($expense->title) }}')">
            Delete Transaction
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
