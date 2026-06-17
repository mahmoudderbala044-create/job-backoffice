<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyEditRequest extends FormRequest
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
        $companyId = $this->route('company');
        if (!$companyId && auth()->check()) {
            $companyId = \App\Models\Company::where('owner_id', auth()->id())->value('id');
        }
    
        return [
            'name' => 'required|string|max:255|unique:companies,name,' . $companyId,
            'address' => 'required|string|max:255',
            'industry' => 'required|string|in:tech,education,healthcare,finance,other',
            'website' => 'nullable|url|max:255',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Company name is required',
            'name.unique' => 'Company name already exists',
            'address.required' => 'Company address is required',
            'address.max' => 'Company address cannot exceed 255 characters',
            'industry.required' => 'Company industry is required',
            'industry.in' => 'Company industry must be one of the following: tech, education, healthcare, finance, other',
            'website.required' => 'Company website is required',
            'website.url' => 'Company website must be a valid URL',
            'website.max' => 'Company website cannot exceed 255 characters',
        ];
    }
}
