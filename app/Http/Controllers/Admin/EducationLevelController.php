<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationLevelController extends Controller
{
    public function index()
    {
        $educationLevels = EducationLevel::latest()->paginate(20);
        return view('admin.education-levels.index', compact('educationLevels'));
    }

    public function create()
    {
        return view('admin.education-levels.create');
    }

    public function store(Request $request)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:education_levels,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        EducationLevel::create($data);

        return redirect()->route('admin.education-levels.index')
            ->with('success', 'Education level created successfully!');
    }

    public function edit(EducationLevel $educationLevel)
    {
        return view('admin.education-levels.edit', compact('educationLevel'));
    }

    public function update(Request $request, EducationLevel $educationLevel)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:education_levels,name,' . $educationLevel->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $educationLevel->update($data);

        return redirect()->route('admin.education-levels.index')
            ->with('success', 'Education level updated successfully!');
    }

    public function destroy(EducationLevel $educationLevel)
    {
        if ($educationLevel->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete education level. It has associated jobs.');
        }

        $educationLevel->delete();

        return redirect()->back()
            ->with('success', 'Education level deleted successfully!');
    }
}

