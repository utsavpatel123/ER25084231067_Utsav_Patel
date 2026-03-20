<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('expenses')
            ->withSum(['expenses as total_spent' => fn($q) => $q->where('type','expense')], 'amount')
            ->orderBy('name')
            ->get();
        return view('categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return back()->with('success', 'Category "' . $request->name . '" created.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:100', 'unique:categories,name,' . $category->id],
            'icon'  => ['required', 'string', 'max:10'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'type'  => ['required', 'in:expense,income,both'],
        ]);
        $category->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->expenses()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing transactions. Reassign them first.');
        }
        if ($category->is_default) {
            return back()->with('error', 'Cannot delete a default category.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
