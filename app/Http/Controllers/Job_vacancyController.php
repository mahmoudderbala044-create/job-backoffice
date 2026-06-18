<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_Vacancy;
use App\Models\Job_Category;
use App\Models\Company;
use App\Http\Requests\Job_VacancyCreateRequest;
use App\Http\Requests\Job_VacancyEditRequest;

class Job_VacancyController extends Controller
{

    private const types = [
        'Full-time',
        'Contract',
        'Hybrid',
        'Remote',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job_Vacancy::latest();
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = self::types;
        $job_categories = Job_category::all();
        $companies = Company::all();
        return view('job-vacancy.create', compact('job_categories', 'companies', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Job_VacancyCreateRequest $request)
    {
        $validated = $request->validated();
        Job_Vacancy::create($validated);
        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job_vacancy = Job_Vacancy::findOrFail($id);
        
        return view('job-vacancy.show', compact('job_vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $types = self::types;
        $job_vacancy = Job_Vacancy::findOrFail($id);
        $job_categories = Job_category::all();
        $companies = Company::all();
        return view('job-vacancy.edit', compact('job_vacancy', 'job_categories', 'companies', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Job_VacancyEditRequest $request, string $id)
    {
         $job_vacancy = Job_Vacancy::findOrFail($id);
        $job_vacancy->update($request->validated());

        if(request()->query('redirectToList')=="true"){
            return redirect()->route('job-vacancy.show', $job_vacancy->id)->with('success', 'Job Vacancy updated successfully.');
        } 

        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy updated successfully.');
    }


    public function destroy(string $id)
    {
           $job_vacancy = Job_Vacancy::findOrFail($id);
        $job_vacancy->delete();
        return redirect()->route('job-vacancy.index')->with('success', 'Job Vacancy deleted successfully.');
    }

     public function restore($id)
    {
        $job_vacancy = Job_Vacancy::onlyTrashed()->findOrFail($id);
        $job_vacancy->restore();
        return redirect()->route('job-vacancy.index', ['Archive' => 'true'])->with('success', 'Job Vacancy restored successfully.');
    }
}
    
