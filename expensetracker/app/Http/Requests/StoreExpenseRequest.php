<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return session('admin_logged_in', false); }

    public function rules(): array
    {
        return [
            'type'             => ['required', 'in:expense,income'],
            'category_id'      => ['required', 'exists:categories,id'],
            'title'            => ['required', 'string', 'min:2', 'max:200'],
            'amount'           => ['required', 'numeric', 'min:0.01', 'max:99999999'],
            'date'             => ['required', 'date', 'before_or_equal:today'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'payment_method'   => ['required', 'in:Cash,Card,UPI,Bank Transfer,Cheque,Other'],
            'reference'        => ['nullable', 'string', 'max:100'],
            'is_recurring'     => ['boolean'],
            'recurring_period' => ['nullable', 'required_if:is_recurring,1', 'in:daily,weekly,monthly,yearly'],
            'tags'             => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'             => 'Please select expense or income.',
            'category_id.required'      => 'Please select a category.',
            'category_id.exists'        => 'Selected category does not exist.',
            'title.required'            => 'Title is required.',
            'title.min'                 => 'Title must be at least 2 characters.',
            'amount.required'           => 'Amount is required.',
            'amount.numeric'            => 'Amount must be a number.',
            'amount.min'                => 'Amount must be greater than 0.',
            'date.required'             => 'Date is required.',
            'date.before_or_equal'      => 'Date cannot be in the future.',
            'payment_method.required'   => 'Payment method is required.',
            'payment_method.in'         => 'Invalid payment method selected.',
            'recurring_period.required_if' => 'Please select a recurring period.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json(['success' => false, 'errors' => $validator->errors()], 422)
            );
        }
        parent::failedValidation($validator);
    }
}
