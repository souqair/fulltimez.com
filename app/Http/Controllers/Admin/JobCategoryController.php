<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    public function index()
    {
        $categories = JobCategory::latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        JobCategory::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(JobCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, JobCategory $category)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(JobCategory $category)
    {
        // Check if category has jobs
        if ($category->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category. It has associated jobs.');
        }

        $category->delete();

        return redirect()->back()
            ->with('success', 'Category deleted successfully!');
    }
}
