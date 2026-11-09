@extends('admin.layouts.app')

@section('title', 'Job Postings')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Job Postings</h2>
        <a href="{{ route('admin.job-postings.create') }}" class="btn-primary">+ Add Job</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Applications</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="border-t">
                        <td class="p-3">{{ $job->title }}</td>
                        <td class="p-3">{{ $job->job_type }}</td>
                        <td class="p-3 {{ $job->isExpired() ? 'text-red-500' : '' }}">{{ $job->deadline->format('d M, Y') }}
                        </td>
                        <td class="p-3"><a
                                href="{{ route('admin.job-applications.index', ['job_posting_id' => $job->id]) }}"
                                class="text-blue-600 hover:underline">{{ $job->applications_count }}</a></td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $job->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $job->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.job-postings.edit', $job) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.job-postings.destroy', $job) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">No job postings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $jobs->links() }}</div>
@endsection
