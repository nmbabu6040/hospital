@extends('patient.layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Doctor</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Message</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-t">
                        <td class="p-3">{{ $appointment->doctor?->name ?? 'N/A' }}</td>
                        <td class="p-3">{{ \Illuminate\Support\Carbon::parse($appointment->date)->format('d M, Y') }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $appointment->status == 'Confirmed' ? 'bg-green-100 text-green-700' : ($appointment->status == 'Cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $appointment->status }}</span>
                        </td>
                        <td class="p-3 text-gray-500">{{ Str::limit($appointment->message, 40) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">কোনো অ্যাপয়েন্টমেন্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $appointments->links() }}</div>
@endsection
