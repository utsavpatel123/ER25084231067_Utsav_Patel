<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool { return session('admin_logged_in', false); }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:2', 'max:100', 'unique:categories,name'],
            'icon'  => ['required', 'string', 'max:10'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'type'  => ['required', 'in:expense,income,both'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique'   => 'A category with this name already exists.',
            'color.regex'   => 'Color must be a valid hex code like #4361ee.',
        ];
    }
}
