<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyEditRequest extends FormRequest
{
    public function rules(): array
    {
    
        return [
             'title' => 'required|string|max:255|unique:job_vacancies,title,' . $this->route('job_vacancy'),
            'description'=>'required|string',
            'salary'=>'required|string|max:255',
            'location'=>'nullable|string|max:255',
            'type'=>'required|string|max:255',
            'required_skills'=>'nullable|string|max:255',
            'company_id'=>'required|string|max:255',
            'job_category_id'=>'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
           'title.required' => 'title name is required',
            'description.required' => 'description is required',
            'salary.required' => 'salary is required',
            'location.required' => 'location is required',
            'type.required' => 'type is required',
            'required_skills.required' => 'required_skills is required',
            'company_id.required' => 'company_id is required',
            'job_category_id.required' => 'job_category_id is required',
        ];
    }
}
