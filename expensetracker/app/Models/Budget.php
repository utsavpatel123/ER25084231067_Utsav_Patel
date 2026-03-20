<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'category_id', 'name', 'amount', 'period',
        'period_year', 'period_month', 'is_active',
    ];

    protected $casts = ['amount' => 'decimal:2', 'is_active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getSpentAttribute(): float
    {
        $query = Expense::where('type', 'expense')
            ->whereYear('date', $this->period_year);

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        if ($this->period === 'monthly' && $this->period_month) {
            $query->whereMonth('date', $this->period_month);
        }
        return round((float) $query->sum('amount'), 2);
    }

    public function getRemainingAttribute(): float
    {
        return round($this->amount - $this->spent, 2);
    }

    public function getPercentUsedAttribute(): float
    {
        if ($this->amount <= 0) return 0;
        return min(100, round(($this->spent / $this->amount) * 100, 1));
    }

    public function getStatusAttribute(): string
    {
        $pct = $this->percent_used;
        if ($pct >= 100) return 'exceeded';
        if ($pct >= 80)  return 'warning';
        return 'good';
    }
}
