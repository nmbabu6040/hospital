<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::withCount('applications')->latest()->paginate(20);

        return view('admin.job-postings.index', compact('jobs'));
    }

    public function create()
    {
        $jobPosting = new JobPosting();

        return view('admin.job-postings.form', compact('jobPosting'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        JobPosting::create($data);

        return redirect()->route('admin.job-postings.index')->with('success', 'Job posting created successfully.');
    }

    public function edit(JobPosting $jobPosting)
    {
        return view('admin.job-postings.form', compact('jobPosting'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        $data = $this->validateData($request);
        $jobPosting->update($data);

        return redirect()->route('admin.job-postings.index')->with('success', 'Job posting updated successfully.');
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();

        return back()->with('success', 'Job posting deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'job_type' => ['required', 'in:Full-time,Part-time,Contract,Internship'],
            'location' => ['nullable', 'string', 'max:255'],
            'vacancies' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'deadline' => ['required', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
