@extends('doctor.layouts.app')

@section('title', 'My Appointments')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Patient</th>
                    <th class="p-3">Date/Time</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Update</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-t">
                        <td class="p-3">{{ $appointment->name }}<br><span
                                class="text-xs text-gray-400">{{ $appointment->phone }}</span></td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}
                            {{ $appointment->slot_time ? \Carbon\Carbon::parse($appointment->slot_time)->format('h:i A') : '' }}
                        </td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $appointment->status == 'Confirmed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $appointment->status }}</span>
                        </td>
                        <td class="p-3">
                            <form action="{{ route('doctor.appointments.update', $appointment) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="border border-gray-200 rounded-md px-2 py-1 text-xs">
                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="Confirmed" {{ $appointment->status == 'Confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $appointments->links() }}</div>
@endsection
