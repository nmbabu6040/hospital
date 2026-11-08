@extends('admin.layouts.app')

@section('title', 'Blood Donors')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Blood Donors</h2>
    </div>

    <form method="GET" class="mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or phone..."
            class="w-full md:w-80 border border-gray-200 rounded-md px-4 py-2 text-sm">
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Blood Group</th>
                    <th class="p-3">Location</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donors as $donor)
                    <tr class="border-t">
                        <td class="p-3">{{ $donor->name }}</td>
                        <td class="p-3"><span
                                class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $donor->blood_group }}</span>
                        </td>
                        <td class="p-3">{{ $donor->district }}{{ $donor->area ? ', ' . $donor->area : '' }}</td>
                        <td class="p-3">{{ $donor->phone }}</td>
                        <td class="p-3 space-x-1">
                            @if ($donor->is_verified)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Verified</span>
                            @endif
                            @if ($donor->is_available)
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">Available</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full text-xs">Unavailable</span>
                            @endif
                        </td>
                        <td class="p-3 space-x-2 text-xs">
                            <form action="{{ route('admin.blood-donors.verify', $donor) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button
                                    class="text-green-600 hover:underline">{{ $donor->is_verified ? 'Unverify' : 'Verify' }}</button>
                            </form>
                            <form action="{{ route('admin.blood-donors.available', $donor) }}" method="POST"
                                class="inline">
                                @csrf @method('PATCH')
                                <button
                                    class="text-blue-600 hover:underline">{{ $donor->is_available ? 'Mark Unavailable' : 'Mark Available' }}</button>
                            </form>
                            <form action="{{ route('admin.blood-donors.destroy', $donor) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">No donors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $donors->links() }}</div>
@endsection
