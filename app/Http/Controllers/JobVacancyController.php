<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\JobCategory;
use App\Models\Company;
use App\Http\Requests\Job_VacancyCreateRequest;
use App\Http\Requests\Job_VacancyEditRequest;

class JobVacancyController extends Controller
{

    private const types = [
        'Full-time',
        'Contract',
        'Hybrid',
        'Remote',
    ];

    public function index(Request $request)
    {
        $query = JobVacancy::latest();
        if($request->input('Archive') == 'true'){
            $query->onlyTrashed();
        }
       
        if(auth()->user()->role == 'admin'){
            $job_vacancies = $query->paginate(10)->onEachSide(1);
        }elseif(auth()->user()->role == 'company-owner'){
            $company = Company::where('owner_id', auth()->user()->id)->firstOrFail();
            $job_vacancies = $query->where('company_id', $company->id)->paginate(10)->onEachSide(1);
        }
        
        return view('job-vacancy.index', compact('job_vacancies'));
    }    

    public function create()
    {
        $types = self::types;
        $job_categories = JobCategory::all();
        $companies = Company::all();
        return view('job-vacancy.create', compact('job_categories', 'companies', 'types'));
    }

    public function store(Job_VacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy created successfully');
    }

    public function show(string $id)
    {
        $job_vacancy = JobVacancy::findOrFail($id);
        
        return view('job-vacancy.show', compact('job_vacancy'));
    }

    public function edit(string $id)
    {
       $types = self::types;
        $job_vacancy = JobVacancy::findOrFail($id);
        $job_categories = JobCategory::all();
        $companies = Company::all();
        return view('job-vacancy.edit', compact('job_vacancy', 'job_categories', 'companies', 'types'));
    }

    public function update(Job_VacancyEditRequest $request, string $id)
    {
         $job_vacancy = JobVacancy::findOrFail($id);
        $job_vacancy->update($request->validated());

        if(request()->query('redirectToList')=="true"){
            return redirect()->route('job-vacancy.show', $job_vacancy->id)->with('success', 'Job Vacancy updated successfully.');
        } 

        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy updated successfully.');
    }


    public function destroy(string $id)
    {
           $job_vacancy = JobVacancy::findOrFail($id);
        $job_vacancy->delete();
        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy deleted successfully.');
    }

     public function restore($id)
    {
        $job_vacancy = JobVacancy::onlyTrashed()->findOrFail($id);
        $job_vacancy->restore();
        return redirect()->route('job-vacancy.index', ['Archive' => 'true'])->with('success', 'Job Vacancy restored successfully.');
    }
}
