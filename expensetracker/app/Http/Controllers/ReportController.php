<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->integer('year', now()->year);
        $month = $request->integer('month', 0); // 0 = all months

        abort_if($year < 2000 || $year > 2100, 422, 'Invalid year.');
        abort_if($month < 0 || $month > 12, 422, 'Invalid month.');

        $query = Expense::with('category')->whereYear('date', $year);
        if ($month > 0) $query->whereMonth('date', $month);

        $expenses      = $query->where('type', 'expense')->sum('amount');
        $incomes       = $query->where('type', 'income')->sum('amount');

        // Category breakdown
        $byCategory = Category::withSum(
            ['expenses as total' => fn($q) => $q->where('type','expense')->whereYear('date',$year)
                ->when($month > 0, fn($q2) => $q2->whereMonth('date',$month))],
            'amount'
        )->having('total', '>', 0)->orderByDesc('total')->get();

        // Monthly breakdown
        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthly[$m] = [
                'label'   => date('M', mktime(0,0,0,$m,1)),
                'expense' => (float) Expense::where('type','expense')->whereYear('date',$year)->whereMonth('date',$m)->sum('amount'),
                'income'  => (float) Expense::where('type','income')->whereYear('date',$year)->whereMonth('date',$m)->sum('amount'),
            ];
        }

        // Payment method breakdown
        $byPayment = Expense::where('type','expense')->whereYear('date',$year)
            ->when($month > 0, fn($q) => $q->whereMonth('date',$month))
            ->selectRaw('payment_method, SUM(amount) as total')
            ->groupBy('payment_method')->orderByDesc('total')->get();

        $years  = range(now()->year - 2, now()->year + 1);
        $months = array_combine(range(1,12), array_map(fn($m) => date('F', mktime(0,0,0,$m,1)), range(1,12)));

        return view('reports.index', compact(
            'expenses','incomes','byCategory','monthly','byPayment',
            'year','month','years','months'
        ));
    }
}
