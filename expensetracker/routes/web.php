<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;

// ── Guest ─────────────────────────────────────────────────────────────────
Route::middleware('guest.admin')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post')
         ->middleware('throttle.login');
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->name('auth.logout')->middleware('auth.admin');

// ── Authenticated ─────────────────────────────────────────────────────────
Route::middleware(['auth.admin', 'log.activity'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Expenses (income + expense transactions)
    Route::resource('expenses', ExpenseController::class);

    // Categories
    Route::get('/categories',                [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories',               [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}',     [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',  [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Budgets
    Route::get('/budgets',              [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets',             [BudgetController::class, 'store'])->name('budgets.store');
    Route::put('/budgets/{budget}',     [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}',  [BudgetController::class, 'destroy'])->name('budgets.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

Route::fallback(function () {
    return response()->view('errors.404', ['message' => 'Page not found.'], 404);
});
