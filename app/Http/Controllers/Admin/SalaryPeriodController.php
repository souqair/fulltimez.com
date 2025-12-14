<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SalaryPeriodController extends Controller
{
    public function index()
    {
        $periods = SalaryPeriod::latest()->paginate(20);
        return view('admin.salary-periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.salary-periods.create');
    }

    public function store(Request $request)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:salary_periods,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        SalaryPeriod::create($data);

        return redirect()->route('admin.salary-periods.index')
            ->with('success', 'Salary period created successfully!');
    }

    public function edit(SalaryPeriod $salaryPeriod)
    {
        return view('admin.salary-periods.edit', compact('salaryPeriod'));
    }

    public function update(Request $request, SalaryPeriod $salaryPeriod)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:salary_periods,name,' . $salaryPeriod->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $salaryPeriod->update($data);

        return redirect()->route('admin.salary-periods.index')
            ->with('success', 'Salary period updated successfully!');
    }

    public function destroy(SalaryPeriod $salaryPeriod)
    {
        if ($salaryPeriod->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete salary period. It has associated jobs.');
        }

        $salaryPeriod->delete();

        return redirect()->back()
            ->with('success', 'Salary period deleted successfully!');
    }
}

