<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyEditRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class CompanyController extends Controller
{

    public $industries=['tech','education','healthcare','finance','other'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quiery = Company::latest();
        if($request->input('Archive') == 'true'){
            $quiery->onlyTrashed();
        }
        $companies = $quiery->paginate(10)->onEachSide(1);
        
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create',compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make($validated['password']),
                'role' => 'company-owner',
            ]);

            Company::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'industry' => $validated['industry'],
                'website' => $validated['website'],
                'owner_id' => $user->id,
            ]);
        });

        return redirect()->route('company.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($id) {
        $company = Company::findOrFail($id);
    } else {
        $company = Company::where('owner_id', auth()->id())->firstOrFail();
    }
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
       $company= $this->getid($id); 
       $industries = $this->industries;
        return view('company.edit', compact('company','industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyEditRequest $request , string $id = null)
    {
       $company = $this->getid($id); 
       
        $company->update($request->validated());

        if(auth()->user()->role == 'company-owner'){
            return redirect()->route('my_company.show')->with('success', 'Company updated successfully.');
        }

        if(request()->query('redirectToList')=="true"){
            return redirect()->route('company.show', $company->id)->with('success', 'Company updated successfully.');
        } 

        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company deleted successfully.');
    }

    public function restore($id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index', ['Archive' => 'true'])->with('success', 'Company restored successfully.');
    }


    public function getid(string $id = null){
        if ($id) {
             return Company::findOrFail($id);
        } else {
             return Company::where('owner_id', auth()->id())->firstOrFail();
        }
    }    
}

