@extends('admin.layouts.app')

@section('title', 'Job Applications')

@section('content')
    <h2 class="text-lg font-semibold mb-5">Job Applications</h2>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow-sm mb-6">
        <select name="job_posting_id" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Jobs</option>
            @foreach ($jobPostings as $job)
                <option value="{{ $job->id }}" {{ request('job_posting_id') == $job->id ? 'selected' : '' }}>
                    {{ $job->title }}</option>
            @endforeach
        </select>
        <select name="status" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
        </select>
        <button type="submit" class="btn-primary text-sm">Filter</button>
    </form>

    <div class="space-y-4">
        @forelse($applications as $application)
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-semibold text-sm">{{ $application->applicant_name }}</p>
                        <p class="text-xs text-gray-400">{{ $application->email }} · {{ $application->phone }}</p>
                        <p class="text-xs text-gray-500 mt-1">Applied for:
                            <strong>{{ $application->jobPosting->title }}</strong></p>
                        @if ($application->cover_letter)
                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($application->cover_letter, 150) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ asset('storage/' . $application->cv_file) }}" target="_blank"
                            class="btn-outline text-xs px-3 py-1.5">📄 View CV</a>
                        <form action="{{ route('admin.job-applications.update', $application) }}" method="POST"
                            class="flex items-center gap-1">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="border border-gray-200 rounded-md px-2 py-1 text-xs">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>
                                    Shortlisted</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                    Rejected</option>
                                <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired
                                </option>
                            </select>
                        </form>
                        <form action="{{ route('admin.job-applications.destroy', $application) }}" method="POST"
                            onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-xs hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No applications found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
