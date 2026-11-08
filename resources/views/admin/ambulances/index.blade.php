@extends('admin.layouts.app')

@section('title', 'Ambulance Fleet')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Ambulance Fleet</h2>
        <a href="{{ route('admin.ambulances.create') }}" class="btn-primary">+ Add Ambulance</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Vehicle No</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Driver</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ambulances as $ambulance)
                    <tr class="border-t">
                        <td class="p-3">{{ $ambulance->vehicle_no }}</td>
                        <td class="p-3">{{ $ambulance->type }}</td>
                        <td class="p-3">{{ $ambulance->driver_name }}
                            {{ $ambulance->driver_phone ? '(' . $ambulance->driver_phone . ')' : '' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $ambulance->status == 'available' ? 'bg-green-100 text-green-700' : ($ambulance->status == 'on_duty' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500') }}">
                                {{ ucfirst(str_replace('_', ' ', $ambulance->status)) }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.ambulances.edit', $ambulance) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.ambulances.destroy', $ambulance) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No ambulances found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $ambulances->links() }}</div>
@endsection
