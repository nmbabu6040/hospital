@extends('admin.layouts.app')

@section('title', 'Appointments')

@section('content')
    <h2 class="text-lg font-semibold mb-5">All Appointments</h2>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Doctor</th>
                    <th class="p-3">Branch</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-t">
                        <td class="p-3">{{ $appointment->name }}</td>
                        <td class="p-3">{{ $appointment->phone }}</td>
                        <td class="p-3">{{ $appointment->doctor?->name ?? '—' }}</td>
                        <td class="p-3">{{ $appointment->branch?->name ?? '—' }}</td>
                        <td class="p-3">{{ \Illuminate\Support\Carbon::parse($appointment->date)->format('d M, Y') }}
                        </td>
                        <td class="p-3">
                            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST"
                                class="inline-flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="border border-gray-200 rounded-md px-2 py-1 text-xs
                                    {{ $appointment->status == 'Confirmed' ? 'bg-green-50 text-green-700' : ($appointment->status == 'Cancelled' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="Confirmed" {{ $appointment->status == 'Confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-3">
                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-gray-500">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $appointments->links() }}</div>
@endsection
