# ExpenseTracker — Expense Management System

Laravel 11 · MySQL · Plus Jakarta Sans · Same stack as EduVault

---

## Features
- **Dashboard** — Monthly/yearly summary, recent transactions, 6-month trend, budget status, top categories
- **Transactions** — Add income & expense, filter by type/category/method/date range, paginated list
- **Categories** — Add/edit/delete with icon + color, track spending per category
- **Budgets** — Set monthly budgets per category, track % used with visual progress bars
- **Reports** — Monthly breakdown, category pie, payment method breakdown, savings rate

## Security & Architecture
- Middleware: SecurityHeaders, Authenticate, RedirectIfAuthenticated, ThrottleLogin (5 attempts/min), LogActivity
- Form Requests: StoreExpenseRequest, UpdateExpenseRequest, StoreCategoryRequest, StoreBudgetRequest, LoginRequest
- Exception Handler: Custom 404/500/CSRF error pages
- Session: Regenerated on login, invalidated on logout
- CSRF: All forms protected

---

## Setup (XAMPP + Windows)

### Step 1 — Start XAMPP
Apache + MySQL must be running

### Step 2 — Create database
http://localhost/phpmyadmin → New → `expensetracker` → Create

### Step 3 — Open CMD in project folder
```
cd C:\xampp\htdocs\expensetracker
```

### Step 4 — Run commands
```
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

### Step 5 — Open browser
```
http://localhost:8000
```
**Username:** admin | **Password:** admin123

### Next time
Double-click `start.bat` or run `php artisan serve`

---

## Database Tables
- `categories` — name, icon, color, type (expense/income/both)
- `expenses` — title, amount, type, date, payment_method, category_id, tags, recurring
- `budgets` — name, amount, period, category_id, period_year, period_month

## Payment Methods
Cash · Card · UPI · Bank Transfer · Cheque · Other
