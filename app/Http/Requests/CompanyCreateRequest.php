<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'address'=>'required|string|max:255',
            'industry'=>'required|string|max:255',
            'website'=>'nullable|url|string|max:255',
            'owner_name'=>'required|string|max:255|unique:users,name',
            'owner_email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6',
        ];
    }

    public function messages()  
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name already exists',
            'address.required' => 'address is required',
            'industry.required' => 'industry is required',
            'website.url' => 'website is not valid',
            'owner_name.required' => 'owner name is required',
            'owner_email.required' => 'owner email is required',
            'owner_email.unique' => 'owner email already exists',
            'password.required' => 'password is required',
            'password.min' => 'password must be at least 6 characters long',
        ];
    }
}
