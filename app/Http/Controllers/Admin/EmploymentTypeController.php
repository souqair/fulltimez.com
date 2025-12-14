<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employmentTypes = EmploymentType::latest()->paginate(20);
        return view('admin.employment-types.index', compact('employmentTypes'));
    }

    public function create()
    {
        return view('admin.employment-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:employment_types,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');

        EmploymentType::create($data);

        return redirect()->route('admin.employment-types.index')
            ->with('success', 'Employment type created successfully!');
    }

    public function edit(EmploymentType $employmentType)
    {
        return view('admin.employment-types.edit', compact('employmentType'));
    }

    public function update(Request $request, EmploymentType $employmentType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:employment_types,name,' . $employmentType->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');

        $employmentType->update($data);

        return redirect()->route('admin.employment-types.index')
            ->with('success', 'Employment type updated successfully!');
    }

    public function destroy(EmploymentType $employmentType)
    {
        // Check if employment type has jobs
        if ($employmentType->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete employment type. It has associated jobs.');
        }

        $employmentType->delete();

        return redirect()->back()
            ->with('success', 'Employment type deleted successfully!');
    }
}

