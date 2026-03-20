<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'icon', 'color', 'type', 'is_default'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function totalExpenses(string $period = 'month'): float
    {
        $query = $this->expenses()->where('type', 'expense');
        if ($period === 'month') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('date', now()->year);
        }
        return round((float) $query->sum('amount'), 2);
    }
}
