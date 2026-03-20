<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private const PAYMENT_METHODS = ['Cash', 'Card', 'UPI', 'Bank Transfer', 'Cheque', 'Other'];

    public function index(Request $request)
    {
        $query = Expense::with('category')->orderBy('date', 'desc')->orderBy('id', 'desc');

        // Search
        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($type = $request->string('type')->trim()->value()) {
            abort_if(!in_array($type, ['expense', 'income']), 422, 'Invalid type.');
            $query->where('type', $type);
        }

        if ($cat = $request->string('category')->trim()->value()) {
            $query->where('category_id', $cat);
        }

        if ($method = $request->string('payment_method')->trim()->value()) {
            abort_if(!in_array($method, self::PAYMENT_METHODS), 422, 'Invalid payment method.');
            $query->where('payment_method', $method);
        }

        // Date range
        $dateFrom = $request->date_from;
        $dateTo   = $request->date_to;
        if ($dateFrom && $dateTo) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        $expenses   = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // Summary for filtered results
        $allFiltered    = $query->get();
        $totalExpense   = Expense::with('category')->where('type', 'expense')->thisMonth()->sum('amount');
        $totalIncome    = Expense::with('category')->where('type', 'income')->thisMonth()->sum('amount');
        $balance        = $totalIncome - $totalExpense;

        $paymentMethods = self::PAYMENT_METHODS;

        return view('expenses.index', compact(
            'expenses', 'categories', 'totalExpense',
            'totalIncome', 'balance', 'paymentMethods'
        ));
    }

    public function create()
    {
        $categories     = Category::orderBy('name')->get();
        $paymentMethods = self::PAYMENT_METHODS;
        return view('expenses.create', compact('categories', 'paymentMethods'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();
        $data['is_recurring'] = $request->boolean('is_recurring');
        Expense::create($data);

        return redirect()
            ->route('expenses.index')
            ->with('success', ucfirst($data['type']) . ' "' . $data['title'] . '" added successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load('category');
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories     = Category::orderBy('name')->get();
        $paymentMethods = self::PAYMENT_METHODS;
        return view('expenses.edit', compact('expense', 'categories', 'paymentMethods'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $data = $request->validated();
        $data['is_recurring'] = $request->boolean('is_recurring');
        $expense->update($data);

        return redirect()
            ->route('expenses.show', $expense)
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $title = $expense->title;
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', "Transaction \"{$title}\" deleted.");
    }
}
