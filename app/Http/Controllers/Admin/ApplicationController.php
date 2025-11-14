<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with(['job', 'seeker.seekerProfile']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(20);

        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        $application->load(['job.employer.employerProfile', 'seeker.seekerProfile']);
        
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,accepted,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }

    public function update(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,accepted,rejected',
            'cover_letter' => 'nullable|string',
            'employer_notes' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
            'reviewed_at' => 'nullable|date',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application updated successfully!');
    }

    public function destroy(JobApplication $application)
    {
        $application->delete();

        return redirect()->back()->with('success', 'Application deleted successfully!');
    }

    /**
     * Download the application's cover letter as a PDF.
     * If the cover letter is stored as plain text, we render it into a simple PDF.
     */
    public function downloadCoverLetter(JobApplication $application)
    {
        // Authorization: admin area routes are already behind 'role:admin'
        if (!$application->cover_letter || trim($application->cover_letter) === '') {
            return redirect()->back()->with('error', 'No cover letter found for this application.');
        }

        $candidateName = $application->seeker->seekerProfile->full_name ?? $application->seeker->name;
        $jobTitle = $application->job->title ?? 'Job';

        // Render minimal view inline for PDF
        $html = view('admin.applications.partials.cover-letter-pdf', [
            'application' => $application,
            'candidateName' => $candidateName,
            'jobTitle' => $jobTitle,
        ])->render();

        $pdf = Pdf::loadHTML($html)->setPaper('A4');
        $filename = 'Cover_Letter_' . preg_replace('/\s+/', '_', $candidateName) . '.pdf';
        return $pdf->download($filename);
    }
}



