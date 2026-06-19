<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\Company;
use App\Http\Requests\JobApplicationEditRequest;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::latest();
        if($request->input('Archive') == 'true'){
            $query->onlyTrashed();
        }
        
        if(auth()->user()->role == 'admin'){
            $job_applications = $query->paginate(10)->onEachSide(1);
        }elseif(auth()->user()->role == 'company-owner'){
            $company = Company::where('owner_id', auth()->user()->id)->firstOrFail();
            $job_applications = $query->whereHas('job_vacancy', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })->paginate(10)->onEachSide(1);
        }
        
        return view('job-application.index', compact('job_applications'));
    }

    public function show(string $id)
    {
        $job_application = JobApplication::findOrFail($id);
        return view('job-application.show', compact('job_application'));
    }

    public function update(JobApplicationEditRequest $request, string $id)
    {
        $job_application = JobApplication::findOrFail($id);
        $job_application->update([
            'status' => $request->status,
        ]);
        return redirect()->route('job-application.index');
    }

    public function destroy(string $id)
    {
        $job_application = JobApplication::findOrFail($id);
        $job_application->delete();
        return redirect()->route('job-application.index');
    }

     public function restore($id)
    {
        $job_application = JobApplication::onlyTrashed()->findOrFail($id);
        $job_application->restore();
        return redirect()->route('job-application.index', ['Archive' => 'true'])->with('success', 'Job Application restored successfully.');
    }
}
