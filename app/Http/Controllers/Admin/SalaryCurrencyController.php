<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryCurrency;
use Illuminate\Http\Request;

class SalaryCurrencyController extends Controller
{
    public function index()
    {
        $currencies = SalaryCurrency::orderBy('code')->paginate(20);
        return view('admin.salary-currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.salary-currencies.create');
    }

    public function store(Request $request)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'code' => 'required|string|max:3|unique:salary_currencies,code',
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        SalaryCurrency::create($data);

        return redirect()->route('admin.salary-currencies.index')
            ->with('success', 'Salary currency created successfully!');
    }

    public function edit(SalaryCurrency $salaryCurrency)
    {
        return view('admin.salary-currencies.edit', compact('salaryCurrency'));
    }

    public function update(Request $request, SalaryCurrency $salaryCurrency)
    {
        // Convert checkbox value to boolean before validation
        $request->merge(['is_active' => $request->boolean('is_active')]);
        
        $request->validate([
            'code' => 'required|string|max:3|unique:salary_currencies,code,' . $salaryCurrency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        $salaryCurrency->update($data);

        return redirect()->route('admin.salary-currencies.index')
            ->with('success', 'Salary currency updated successfully!');
    }

    public function destroy(SalaryCurrency $salaryCurrency)
    {
        if ($salaryCurrency->jobPostings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete salary currency. It has associated jobs.');
        }

        $salaryCurrency->delete();

        return redirect()->back()
            ->with('success', 'Salary currency deleted successfully!');
    }
}

