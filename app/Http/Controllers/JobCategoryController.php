<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryEditRequest;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        $quiery = JobCategory::latest();
        if($request->input('Archive') == 'true'){
            $quiery->onlyTrashed();
        }
        $categories = $quiery->paginate(10)->onEachSide(1);
        
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryCreateRequest $request)
    {
        JobCategory::create($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(CategoryEditRequest $request, string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->update($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function restore($id)
    {
        $category = JobCategory::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('category.index', ['Archive' => 'true'])->with('success', 'Category restored successfully.');
    }
}
