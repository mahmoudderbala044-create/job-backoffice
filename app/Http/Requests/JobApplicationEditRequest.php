<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationEditRequest extends FormRequest
{
    public function rules(): array
    {
    
        return [
            'status' => 'required|string|in:pending,rejected,accepted',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status is required',
            'status.in' => 'Status must be pending, rejected, or accepted',
        ];
    }
}
