@extends('patient.layouts.app')

@section('title', 'My Reports')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Report ID</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-t">
                        <td class="p-3">{{ $report->report_id }}</td>
                        <td class="p-3">{{ $report->report_date?->format('d M, Y') }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $report->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($report->status) }}</span>
                        </td>
                        <td class="p-3">
                            @if ($report->status == 'ready' && $report->report_file)
                                <a href="{{ route('online-report.download', $report) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Download</a>
                            @elseif($report->status == 'ready' && $report->hasGeneratedReport())
                                <a href="{{ route('online-report.pdf', $report) }}" target="_blank"
                                    class="text-blue-600 hover:underline">View PDF</a>
                            @else
                                <span class="text-gray-400">Not ready</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">কোনো রিপোর্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reports->links() }}</div>
@endsection
