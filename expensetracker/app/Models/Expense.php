<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'category_id', 'type', 'amount', 'title', 'description',
        'date', 'payment_method', 'reference', 'is_recurring',
        'recurring_period', 'tags',
    ];

    protected $casts = [
        'date'         => 'date',
        'amount'       => 'decimal:2',
        'is_recurring' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount, 2);
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? array_map('trim', explode(',', $this->tags)) : [];
    }

    // Scopes
    public function scopeExpenses($q) { return $q->where('type', 'expense'); }
    public function scopeIncomes($q)  { return $q->where('type', 'income'); }
    public function scopeThisMonth($q) {
        return $q->whereMonth('date', now()->month)->whereYear('date', now()->year);
    }
    public function scopeThisYear($q) {
        return $q->whereYear('date', now()->year);
    }
    public function scopeDateRange($q, $from, $to) {
        return $q->whereBetween('date', [$from, $to]);
    }
}
