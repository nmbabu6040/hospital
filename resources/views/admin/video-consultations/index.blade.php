@extends('admin.layouts.app')

@section('title', 'Video Consultations')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Video Consultation Requests</h2>
        <div class="flex gap-2 text-sm">
            <a href="{{ route('admin.video-consultations.index') }}"
                class="px-3 py-1.5 rounded-md {{ !request('status') ? 'bg-brand text-white' : 'bg-gray-100' }}">All</a>
            <a href="{{ route('admin.video-consultations.index', ['status' => 'pending']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100' }}">Pending</a>
            <a href="{{ route('admin.video-consultations.index', ['status' => 'scheduled']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'scheduled' ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">Scheduled</a>
            <a href="{{ route('admin.video-consultations.index', ['status' => 'completed']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">Completed</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Patient</th>
                    <th class="p-3">Doctor</th>
                    <th class="p-3">Preferred</th>
                    <th class="p-3">Scheduled At</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $consultation)
                    <tr class="border-t">
                        <td class="p-3">{{ $consultation->patient_name }}<br><span
                                class="text-xs text-gray-400">{{ $consultation->phone }}</span></td>
                        <td class="p-3">{{ $consultation->doctor?->name ?? 'Any' }}</td>
                        <td class="p-3">{{ $consultation->preferred_date->format('d M, Y') }}
                            {{ $consultation->preferred_time }}</td>
                        <td class="p-3">{{ $consultation->scheduled_at?->format('d M, Y h:i A') ?? '—' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                            {{ $consultation->status == 'scheduled' ? 'bg-blue-100 text-blue-700' : ($consultation->status == 'completed' ? 'bg-green-100 text-green-700' : ($consultation->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')) }}">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.video-consultations.edit', $consultation) }}"
                                class="text-blue-600 hover:underline">Manage</a>
                            <form action="{{ route('admin.video-consultations.destroy', $consultation) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">কোনো রিকোয়েস্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $consultations->links() }}</div>
@endsection
