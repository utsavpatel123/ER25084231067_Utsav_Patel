@extends('layouts.app')
@section('title', e($expense->title))
@section('page-title', 'Transaction Detail')
@section('topbar-actions')
<a href="{{ route('expenses.edit', $expense) }}" class="btn btn-outline btn-sm">Edit</a>
@endsection

@section('content')
<nav class="breadcrumb">
  <a href="{{ route('expenses.index') }}">Transactions</a><span>›</span>
  <span>{{ e($expense->title) }}</span>
</nav>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
  <div>
    <div class="card">
      <div style="padding:24px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;gap:16px">
        <div style="width:56px;height:56px;border-radius:14px;background:{{ $expense->type === 'income' ? 'var(--income-l)' : 'var(--expense-l)' }};display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0">
          {{ $expense->category?->icon ?? '💸' }}
        </div>
        <div style="flex:1">
          <div style="font-size:20px;font-weight:800;color:var(--text)">{{ e($expense->title) }}</div>
          <div style="margin-top:6px;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <span class="badge badge-{{ $expense->type === 'income' ? 'income' : 'expense' }}">{{ ucfirst($expense->type) }}</span>
            <span class="badge badge-gray">{{ $expense->category?->name }}</span>
            <span class="badge badge-gray">{{ $expense->payment_method }}</span>
            @if($expense->is_recurring)<span class="badge badge-blue">🔄 {{ ucfirst($expense->recurring_period) }}</span>@endif
          </div>
        </div>
        <div style="text-align:right;flex-shrink:0">
          <div style="font-size:28px;font-weight:800;color:{{ $expense->type === 'income' ? 'var(--income)' : 'var(--expense)' }}">
            {{ $expense->type === 'income' ? '+' : '-' }}₹{{ number_format($expense->amount,2) }}
          </div>
          <div style="font-size:13px;color:var(--muted);margin-top:4px">{{ $expense->date->format('d F Y') }}</div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border)">
        <div class="info-cell"><div class="info-label">Date</div><div class="info-value">{{ $expense->date->format('d M Y') }}</div></div>
        <div class="info-cell"><div class="info-label">Payment Method</div><div class="info-value">{{ $expense->payment_method }}</div></div>
        <div class="info-cell"><div class="info-label">Category</div><div class="info-value">{{ $expense->category?->icon }} {{ $expense->category?->name }}</div></div>
        <div class="info-cell"><div class="info-label">Reference</div><div class="info-value">{{ $expense->reference ?: '—' }}</div></div>
        @if($expense->description)
        <div class="info-cell" style="grid-column:1/-1">
          <div class="info-label">Description</div>
          <div class="info-value">{{ $expense->description }}</div>
        </div>
        @endif
        @if($expense->tags)
        <div class="info-cell" style="grid-column:1/-1">
          <div class="info-label">Tags</div>
          <div class="info-value" style="display:flex;gap:5px;flex-wrap:wrap;margin-top:4px">
            @foreach($expense->tags_array as $tag)
              <span class="badge badge-gray">{{ $tag }}</span>
            @endforeach
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:14px">
      <div class="card-body">
        <div style="font-size:12.5px;color:var(--muted);line-height:2">
          <div><strong style="color:var(--text2)">Created:</strong> {{ $expense->created_at->format('d M Y, h:i A') }}</div>
          <div><strong style="color:var(--text2)">Last Updated:</strong> {{ $expense->updated_at->diffForHumans() }}</div>
        </div>
      </div>
    </div>
    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:8px;display:flex">Edit Transaction</a>
    <a href="{{ route('expenses.index') }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-bottom:8px;display:flex">← All Transactions</a>
    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" id="del-show">
      @csrf @method('DELETE')
      <button type="button" class="btn btn-ghost" style="width:100%;color:var(--danger);justify-content:center"
        onclick="confirmDelete(document.getElementById('del-show'),'{{ e($expense->title) }}')">Delete</button>
    </form>
  </div>
</div>
@endsection
