<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Services\NotificationService;

class CareerController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::where('is_active', true)
            ->where('deadline', '>=', now()->format('Y-m-d'))
            ->latest()
            ->paginate(10);

        return view('front.career.index', compact('jobs'));
    }

    public function show(JobPosting $jobPosting)
    {
        abort_if(! $jobPosting->is_active, 404);

        return view('front.career.show', compact('jobPosting'));
    }

    public function apply(JobApplicationRequest $request, JobPosting $jobPosting)
    {
        abort_unless($jobPosting->isOpen(), 403, 'এই পদের জন্য আবেদনের সময়সীমা শেষ হয়ে গেছে।');

        $data = $request->validated();
        $data['job_posting_id'] = $jobPosting->id;
        $data['cv_file'] = $request->file('cv_file')->store('cv-uploads', 'public');

        JobApplication::create($data);

        NotificationService::newMessage(
            $data['applicant_name'] . ' applied for ' . $jobPosting->title,
            route('admin.job-applications.index')
        );

        return back()->with('success', 'আপনার আবেদন সফলভাবে জমা হয়েছে। আমরা শীঘ্রই পর্যালোচনা করে যোগাযোগ করবো।');
    }
}
