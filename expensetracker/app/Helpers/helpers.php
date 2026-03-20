<?php

if (!function_exists('money')) {
    function money(float $amount, string $symbol = '₹'): string {
        return $symbol . number_format(abs($amount), 2);
    }
}

if (!function_exists('budget_color')) {
    function budget_color(string $status): string {
        return match($status) {
            'exceeded' => 'red',
            'warning'  => 'amber',
            default    => 'green',
        };
    }
}

if (!function_exists('type_badge_color')) {
    function type_badge_color(string $type): string {
        return $type === 'income' ? 'green' : 'red';
    }
}
