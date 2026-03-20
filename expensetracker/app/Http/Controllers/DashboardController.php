<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        // ── This month summary ────────────────────────────────────────
        $monthExpense = Expense::where('type','expense')->thisMonth()->sum('amount');
        $monthIncome  = Expense::where('type','income')->thisMonth()->sum('amount');
        $monthBalance = $monthIncome - $monthExpense;

        // ── This year summary ─────────────────────────────────────────
        $yearExpense  = Expense::where('type','expense')->thisYear()->sum('amount');
        $yearIncome   = Expense::where('type','income')->thisYear()->sum('amount');

        // ── Last 6 months trend ───────────────────────────────────────
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = $now->copy()->subMonths($i);
            $trend[] = [
                'month'   => $d->format('M Y'),
                'expense' => (float) Expense::where('type','expense')
                                ->whereMonth('date', $d->month)->whereYear('date', $d->year)
                                ->sum('amount'),
                'income'  => (float) Expense::where('type','income')
                                ->whereMonth('date', $d->month)->whereYear('date', $d->year)
                                ->sum('amount'),
            ];
        }

        // ── Top 5 expense categories this month ───────────────────────
        $topCategories = Category::withSum(
            ['expenses as month_total' => fn($q) => $q->where('type','expense')->thisMonth()],
            'amount'
        )->having('month_total', '>', 0)->orderByDesc('month_total')->take(5)->get();

        // ── Recent 8 transactions ──────────────────────────────────────
        $recent = Expense::with('category')->orderBy('date','desc')->orderBy('id','desc')->take(8)->get();

        // ── Budgets status ─────────────────────────────────────────────
        $budgets = Budget::with('category')
            ->where('is_active', true)
            ->where('period_year', $now->year)
            ->where(fn($q) => $q->whereNull('period_month')->orWhere('period_month', $now->month))
            ->take(4)->get();

        // ── Daily expenses last 30 days ───────────────────────────────
        $daily = Expense::where('type','expense')
            ->where('date', '>=', now()->subDays(29)->toDateString())
            ->selectRaw('DATE(date) as day, SUM(amount) as total')
            ->groupBy('day')->orderBy('day')->get()
            ->keyBy('day');

        return view('dashboard', compact(
            'monthExpense','monthIncome','monthBalance',
            'yearExpense','yearIncome',
            'trend','topCategories','recent','budgets','daily'
        ));
    }
}
