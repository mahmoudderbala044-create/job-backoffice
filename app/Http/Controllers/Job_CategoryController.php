<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_Category;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryEditRequest;

class Job_CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quiery = Job_Category::latest();
        if($request->input('Archive') == 'true'){
            $quiery->onlyTrashed();
        }
        $categories = $quiery->paginate(10)->onEachSide(1);
        
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        Job_Category::create($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Job_Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryEditRequest $request, string $id)
    {
        $category = Job_Category::findOrFail($id);
        $category->update($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Job_Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function restore($id)
    {
        $category = Job_Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('category.index', ['Archive' => 'true'])->with('success', 'Category restored successfully.');
    }
}
