<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Http\Requests\StoreBudgetRequest;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets    = Budget::with('category')->where('is_active', true)
                        ->orderBy('period_year', 'desc')->orderBy('period_month', 'desc')->get();
        $categories = Category::orderBy('name')->get();
        $months     = array_combine(range(1,12), array_map(fn($m) => date('F', mktime(0,0,0,$m,1)), range(1,12)));
        $years      = range(now()->year - 1, now()->year + 1);

        return view('budgets.index', compact('budgets', 'categories', 'months', 'years'));
    }

    public function store(StoreBudgetRequest $request)
    {
        Budget::create($request->validated());
        return back()->with('success', 'Budget "' . $request->name . '" created.');
    }

    public function update(StoreBudgetRequest $request, Budget $budget)
    {
        $budget->update($request->validated());
        return back()->with('success', 'Budget updated.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return back()->with('success', 'Budget deleted.');
    }
}
