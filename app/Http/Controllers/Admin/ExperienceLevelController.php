<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExperienceLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExperienceLevelController extends Controller
{
    public function index()
    {
        $experienceLevels = ExperienceLevel::latest()->paginate(20);
        return view('admin.experience-levels.index', compact('experienceLevels'));
    }

    public function create()
    {
        return view('admin.experience-levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:experience_levels,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        ExperienceLevel::create($data);

        return redirect()->route('admin.experience-levels.index')
            ->with('success', 'Experience level created successfully!');
    }

    public function edit(ExperienceLevel $experienceLevel)
    {
        return view('admin.experience-levels.edit', compact('experienceLevel'));
    }

    public function update(Request $request, ExperienceLevel $experienceLevel)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:experience_levels,name,' . $experienceLevel->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $experienceLevel->update($data);

        return redirect()->route('admin.experience-levels.index')
            ->with('success', 'Experience level updated successfully!');
    }

    public function destroy(ExperienceLevel $experienceLevel)
    {
        if ($experienceLevel->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete experience level. It has associated jobs.');
        }

        $experienceLevel->delete();

        return redirect()->back()
            ->with('success', 'Experience level deleted successfully!');
    }
}

