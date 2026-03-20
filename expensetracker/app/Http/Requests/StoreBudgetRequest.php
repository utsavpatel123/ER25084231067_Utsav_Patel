<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool { return session('admin_logged_in', false); }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'amount'       => ['required', 'numeric', 'min:1', 'max:99999999'],
            'period'       => ['required', 'in:weekly,monthly,yearly'],
            'period_year'  => ['required', 'integer', 'min:2000', 'max:2100'],
            'period_month' => ['nullable', 'integer', 'min:1', 'max:12'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Budget name is required.',
            'amount.required'      => 'Budget amount is required.',
            'amount.min'           => 'Budget amount must be at least 1.',
            'period.required'      => 'Please select a period.',
            'period_year.required' => 'Year is required.',
        ];
    }
}
