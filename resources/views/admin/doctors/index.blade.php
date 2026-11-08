@extends('admin.layouts.app')

@section('title', 'Doctors')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Doctors</h2>
        <a href="{{ route('admin.doctors.create') }}" class="btn-primary">+ Add Doctor</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Hospital</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                    <tr class="border-t">
                        <td class="p-3">
                            <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/50x50' }}"
                                class="w-10 h-10 rounded-full object-cover">
                        </td>
                        <td class="p-3">{{ $doctor->name }}</td>
                        <td class="p-3">{{ $doctor->department?->name }}</td>
                        <td class="p-3">{{ $doctor->hospital?->name }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $doctor->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.doctors.edit', $doctor) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <a href="{{ route('admin.doctors.schedule', $doctor) }}"
                                class="text-purple-600 hover:underline">Schedule</a>
                            @if (auth('admin')->user()->canDelete())
                                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete this doctor?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-gray-500">No doctors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $doctors->links() }}</div>
@endsection
