<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('jobPosting');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->job_posting_id);
        }

        $applications = $query->latest()->paginate(20)->withQueryString();
        $jobPostings = \App\Models\JobPosting::orderBy('title')->get();

        return view('admin.job-applications.index', compact('applications', 'jobPostings'));
    }

    public function updateStatus(Request $request, JobApplication $jobApplication)
    {
        $request->validate(['status' => ['required', 'in:pending,shortlisted,rejected,hired']]);

        $jobApplication->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated.');
    }

    public function destroy(JobApplication $jobApplication)
    {
        \Storage::disk('public')->delete($jobApplication->cv_file);
        $jobApplication->delete();

        return back()->with('success', 'Application deleted.');
    }
}
