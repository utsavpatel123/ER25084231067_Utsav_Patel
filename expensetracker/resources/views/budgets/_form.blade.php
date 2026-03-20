<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Budget Name <span class="req">*</span></label>
  <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $b?->name) }}" placeholder="e.g. Food Budget" required>
  @error('name')<div class="form-error">{{ $message }}</div>@enderror
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Category (optional)</label>
  <select class="form-select" name="category_id">
    <option value="">All Categories</option>
    @foreach($categories as $cat)
      <option value="{{ $cat->id }}" @selected(old('category_id', $b?->category_id) == $cat->id)>{{ $cat->icon }} {{ $cat->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Budget Amount (₹) <span class="req">*</span></label>
  <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" value="{{ old('amount', $b?->amount) }}" placeholder="5000" step="0.01" min="1" required>
  @error('amount')<div class="form-error">{{ $message }}</div>@enderror
</div>
<div class="form-grid" style="margin-bottom:12px">
  <div class="form-group">
    <label class="form-label">Period <span class="req">*</span></label>
    <select class="form-select" name="period" required>
      @foreach(['weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly'] as $val => $lbl)
        <option value="{{ $val }}" @selected(old('period', $b?->period ?? 'monthly') === $val)>{{ $lbl }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label class="form-label">Year <span class="req">*</span></label>
    <select class="form-select" name="period_year" required>
      @foreach($years as $y)
        <option value="{{ $y }}" @selected(old('period_year', $b?->period_year ?? now()->year) == $y)>{{ $y }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Month</label>
  <select class="form-select" name="period_month">
    <option value="">All Months</option>
    @foreach($months as $num => $name)
      <option value="{{ $num }}" @selected(old('period_month', $b?->period_month) == $num)>{{ $name }}</option>
    @endforeach
  </select>
</div>
@error('amount')<div class="form-error">{{ $message }}</div>@enderror
