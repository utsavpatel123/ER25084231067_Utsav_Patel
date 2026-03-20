<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends StoreExpenseRequest
{
    public function rules(): array
    {
        // Same rules — date can also be past for edits
        return parent::rules();
    }
}
