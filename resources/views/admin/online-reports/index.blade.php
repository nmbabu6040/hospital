@extends('admin.layouts.app')

@section('title', 'Online Reports')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Patient Reports</h2>
        <a href="{{ route('admin.online-reports.create') }}" class="btn-primary">+ Add Report</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Patient</th>
                    <th class="p-3">Report ID</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-t">
                        <td class="p-3">{{ $report->patient_name }}</td>
                        <td class="p-3">{{ $report->report_id }}</td>
                        <td class="p-3">{{ $report->phone }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $report->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.online-reports.edit', $report) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.online-reports.destroy', $report) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-5 text-center text-gray-500">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $reports->links() }}</div>
@endsection
