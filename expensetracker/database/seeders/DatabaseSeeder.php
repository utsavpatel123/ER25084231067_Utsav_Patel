<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Budget;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──────────────────────────────────────────────────
        $categories = [
            ['name'=>'Food & Dining',    'icon'=>'🍽️',  'color'=>'#ef4444', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Transportation',   'icon'=>'🚗',  'color'=>'#f59e0b', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Shopping',         'icon'=>'🛍️',  'color'=>'#8b5cf6', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Entertainment',    'icon'=>'🎬',  'color'=>'#06b6d4', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Health & Medical', 'icon'=>'🏥',  'color'=>'#10b981', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Utilities',        'icon'=>'💡',  'color'=>'#f97316', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Education',        'icon'=>'📚',  'color'=>'#6366f1', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Rent & Housing',   'icon'=>'🏠',  'color'=>'#ec4899', 'type'=>'expense', 'is_default'=>true],
            ['name'=>'Salary',           'icon'=>'💼',  'color'=>'#10b981', 'type'=>'income',  'is_default'=>true],
            ['name'=>'Freelance',        'icon'=>'💻',  'color'=>'#4361ee', 'type'=>'income',  'is_default'=>true],
            ['name'=>'Investment',       'icon'=>'📈',  'color'=>'#059669', 'type'=>'income',  'is_default'=>true],
            ['name'=>'Other Income',     'icon'=>'💰',  'color'=>'#14b8a6', 'type'=>'income',  'is_default'=>true],
        ];

        foreach ($categories as $c) {
            Category::create($c);
        }

        // ── Sample Expenses (last 3 months) ─────────────────────────────
        $catMap = Category::pluck('id', 'name');

        $samples = [
            // Food
            ['Food & Dining','expense','Lunch at Restaurant','Card',450,'2 people lunch'],
            ['Food & Dining','expense','Grocery Shopping','UPI',1850,'Monthly groceries'],
            ['Food & Dining','expense','Pizza Order','UPI',650,'Dinner'],
            ['Food & Dining','expense','Coffee & Snacks','Cash',180,'Office coffee'],
            // Transport
            ['Transportation','expense','Petrol','Cash',1200,'Full tank'],
            ['Transportation','expense','Uber Ride','UPI',320,'Office commute'],
            ['Transportation','expense','Auto Rickshaw','Cash',85,'Local travel'],
            // Shopping
            ['Shopping','expense','Clothes Shopping','Card',2400,'Monthly shopping'],
            ['Shopping','expense','Electronics','Card',8500,'Headphones'],
            // Entertainment
            ['Entertainment','expense','Netflix Subscription','Card',649,'Monthly'],
            ['Entertainment','expense','Movie Tickets','UPI',520,'Weekend movie'],
            ['Entertainment','expense','Spotify Premium','Card',119,'Monthly'],
            // Health
            ['Health & Medical','expense','Doctor Visit','Cash',500,'Consultation'],
            ['Health & Medical','expense','Medicines','Cash',340,'Monthly medicines'],
            // Utilities
            ['Utilities','expense','Electricity Bill','UPI',1450,'Monthly bill'],
            ['Utilities','expense','Internet Bill','UPI',799,'Monthly broadband'],
            ['Utilities','expense','Mobile Recharge','UPI',599,'Monthly plan'],
            // Rent
            ['Rent & Housing','expense','Monthly Rent','Bank Transfer',15000,'Apartment rent'],
            // Income
            ['Salary','income','Monthly Salary','Bank Transfer',65000,'November salary'],
            ['Salary','income','Monthly Salary','Bank Transfer',65000,'October salary'],
            ['Freelance','income','Web Design Project','Bank Transfer',12000,'Client project'],
            ['Freelance','income','Logo Design','UPI',3500,'Freelance work'],
            ['Investment','income','Stock Dividend','Bank Transfer',2800,'Quarterly dividend'],
        ];

        $now = Carbon::now();
        foreach ($samples as $i => [$cat, $type, $title, $method, $amount, $desc]) {
            $daysAgo = rand(1, 85);
            Expense::create([
                'category_id'    => $catMap[$cat],
                'type'           => $type,
                'title'          => $title,
                'amount'         => $amount + rand(-50, 50),
                'date'           => $now->copy()->subDays($daysAgo)->toDateString(),
                'payment_method' => $method,
                'description'    => $desc,
                'is_recurring'   => in_array($title, ['Monthly Rent','Netflix Subscription','Spotify Premium','Electricity Bill','Internet Bill']),
                'recurring_period' => in_array($title, ['Monthly Rent','Netflix Subscription','Spotify Premium','Electricity Bill','Internet Bill']) ? 'monthly' : null,
            ]);
        }

        // ── Budgets ──────────────────────────────────────────────────────
        $budgetData = [
            ['Food & Dining',    'Food Budget',          8000],
            ['Transportation',   'Transport Budget',      3000],
            ['Shopping',         'Shopping Budget',       5000],
            ['Entertainment',    'Entertainment Budget',  2000],
            ['Utilities',        'Utilities Budget',      4000],
        ];
        foreach ($budgetData as [$cat, $name, $amount]) {
            Budget::create([
                'category_id'  => $catMap[$cat],
                'name'         => $name,
                'amount'       => $amount,
                'period'       => 'monthly',
                'period_year'  => $now->year,
                'period_month' => $now->month,
                'is_active'    => true,
            ]);
        }
    }
}
