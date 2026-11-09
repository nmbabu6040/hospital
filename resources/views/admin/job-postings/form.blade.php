@extends('admin.layouts.app')

@section('title', $jobPosting->exists ? 'Edit Job' : 'Add Job')

@section('content')
    <form
        action="{{ $jobPosting->exists ? route('admin.job-postings.update', $jobPosting) : route('admin.job-postings.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($jobPosting->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Job Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $jobPosting->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Department</label>
                <input type="text" name="department" value="{{ old('department', $jobPosting->department) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location', $jobPosting->location) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Job Type</label>
                <select name="job_type" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    @foreach (['Full-time', 'Part-time', 'Contract', 'Internship'] as $type)
                        <option value="{{ $type }}" {{ $jobPosting->job_type == $type ? 'selected' : '' }}>
                            {{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Vacancies</label>
                <input type="number" name="vacancies" value="{{ old('vacancies', $jobPosting->vacancies ?? 1) }}"
                    min="1" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Deadline <span class="text-red-500">*</span></label>
                <input type="date" name="deadline" value="{{ old('deadline', $jobPosting->deadline?->format('Y-m-d')) }}"
                    required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Salary Range</label>
            <input type="text" name="salary_range" value="{{ old('salary_range', $jobPosting->salary_range) }}"
                placeholder="e.g. 30,000 - 50,000 BDT" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="4" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $jobPosting->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Responsibilities</label>
            <textarea name="responsibilities" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('responsibilities', $jobPosting->responsibilities) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Requirements</label>
            <textarea name="requirements" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('requirements', $jobPosting->requirements) }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $jobPosting->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
