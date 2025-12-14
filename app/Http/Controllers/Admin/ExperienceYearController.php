<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExperienceYear;
use Illuminate\Http\Request;

class ExperienceYearController extends Controller
{
    public function index()
    {
        $experienceYears = ExperienceYear::orderBy('sort_order')->paginate(20);
        return view('admin.experience-years.index', compact('experienceYears'));
    }

    public function create()
    {
        return view('admin.experience-years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255|unique:experience_years,value',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? 0;

        ExperienceYear::create($data);

        return redirect()->route('admin.experience-years.index')
            ->with('success', 'Experience year created successfully!');
    }

    public function edit(ExperienceYear $experienceYear)
    {
        return view('admin.experience-years.edit', compact('experienceYear'));
    }

    public function update(Request $request, ExperienceYear $experienceYear)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255|unique:experience_years,value,' . $experienceYear->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? 0;

        $experienceYear->update($data);

        return redirect()->route('admin.experience-years.index')
            ->with('success', 'Experience year updated successfully!');
    }

    public function destroy(ExperienceYear $experienceYear)
    {
        if ($experienceYear->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete experience year. It has associated jobs.');
        }

        $experienceYear->delete();

        return redirect()->back()
            ->with('success', 'Experience year deleted successfully!');
    }
}

