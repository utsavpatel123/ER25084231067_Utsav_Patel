@extends('layouts.app')
@section('title','Budgets')
@section('page-title','Budgets')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

  {{-- Budget cards --}}
  <div>
    @if($budgets->isEmpty())
      <div class="card">
        <div class="empty-state">
          <div class="empty-state-icon">📊</div>
          <h3>No budgets set</h3>
          <p>Create a budget on the right to start tracking your spending limits.</p>
        </div>
      </div>
    @else
    <div class="budget-grid">
      @foreach($budgets as $b)
      @php
        $pct      = $b->percent_used;
        $status   = $b->status;
        $barClass = $status === 'exceeded' ? 'prog-red' : ($status === 'warning' ? 'prog-amber' : 'prog-green');
        $badgeColor = $status === 'exceeded' ? 'red' : ($status === 'warning' ? 'amber' : 'green');
        $statusLabel = ['exceeded'=>'Over Budget','warning'=>'Near Limit','good'=>'On Track'][$status];
      @endphp
      <div class="budget-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
          <div style="display:flex;align-items:center;gap:8px">
            <span style="font-size:22px">{{ $b->category?->icon ?? '📦' }}</span>
            <div>
              <div style="font-weight:700;font-size:14px">{{ e($b->name) }}</div>
              <div style="font-size:11.5px;color:var(--muted)">
                {{ ucfirst($b->period) }} · {{ $b->period_month ? date('M', mktime(0,0,0,$b->period_month,1)) . ' ' : '' }}{{ $b->period_year }}
              </div>
            </div>
          </div>
          <span class="badge badge-{{ $badgeColor }}">{{ $statusLabel }}</span>
        </div>

        <div style="margin-bottom:8px">
          <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
            <span style="color:var(--muted)">₹{{ number_format($b->spent,2) }} spent</span>
            <span style="font-weight:700">₹{{ number_format($b->amount,2) }} budget</span>
          </div>
          <div class="progress" style="height:8px">
            <div class="progress-bar {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--muted);margin-top:4px">
            <span>{{ $pct }}% used</span>
            @if($b->remaining >= 0)
              <span style="color:var(--success)">₹{{ number_format($b->remaining,2) }} left</span>
            @else
              <span style="color:var(--danger)">₹{{ number_format(abs($b->remaining),2) }} over</span>
            @endif
          </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:6px;padding-top:10px;border-top:1px solid var(--border)">
          <button type="button" class="btn btn-outline btn-xs"
            onclick="openEditBudget({{ $b->id }},'{{ e($b->name) }}',{{ $b->category_id ?? 'null' }},{{ $b->amount }},'{{ $b->period }}',{{ $b->period_year }},{{ $b->period_month ?? 'null' }})">
            Edit
          </button>
          <form method="POST" action="{{ route('budgets.destroy', $b) }}" id="bgt-del-{{ $b->id }}">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-xs" style="background:var(--danger-l);color:var(--danger);border:1px solid #fecaca"
              onclick="confirmDelete(document.getElementById('bgt-del-{{ $b->id }}'),'{{ e($b->name) }}')">Delete</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  {{-- Add / Edit budget form --}}
  <div>
    <div class="card">
      <div class="card-header"><div class="card-title" id="bgt-form-title">Add Budget</div></div>
      <div class="card-body">

        {{-- Add form --}}
        <form method="POST" action="{{ route('budgets.store') }}" novalidate id="bgt-add-form">
          @csrf
          @include('budgets._form', ['b' => null])
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:16px">Add Budget</button>
        </form>

        {{-- Edit form --}}
        <form method="POST" id="bgt-edit-form" style="display:none">
          @csrf @method('PUT')
          @include('budgets._form', ['b' => null])
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:16px">Save Changes</button>
          <button type="button" class="btn btn-outline" style="width:100%;margin-top:8px" onclick="cancelBgtEdit()">Cancel</button>
        </form>

      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
function openEditBudget(id, name, catId, amount, period, year, month) {
  document.getElementById('bgt-form-title').textContent = 'Edit Budget';
  document.getElementById('bgt-add-form').style.display = 'none';
  const form = document.getElementById('bgt-edit-form');
  form.action = '/budgets/' + id;
  form.style.display = '';
  form.querySelector('[name="name"]').value         = name;
  form.querySelector('[name="category_id"]').value  = catId || '';
  form.querySelector('[name="amount"]').value       = amount;
  form.querySelector('[name="period"]').value       = period;
  form.querySelector('[name="period_year"]').value  = year;
  form.querySelector('[name="period_month"]').value = month || '';
}
function cancelBgtEdit() {
  document.getElementById('bgt-form-title').textContent = 'Add Budget';
  document.getElementById('bgt-add-form').style.display = '';
  document.getElementById('bgt-edit-form').style.display = 'none';
}
</script>
@endpush
@endsection
