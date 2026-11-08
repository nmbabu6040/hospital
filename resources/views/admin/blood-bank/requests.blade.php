@extends('admin.layouts.app')

@section('title', 'Blood Requests')

@section('content')
    <h2 class="text-lg font-semibold mb-5">Blood Requests</h2>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Patient</th>
                    <th class="p-3">Group</th>
                    <th class="p-3">Hospital</th>
                    <th class="p-3">Needed By</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr class="border-t">
                        <td class="p-3">{{ $request->patient_name }}</td>
                        <td class="p-3"><span
                                class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $request->blood_group }}</span>
                        </td>
                        <td class="p-3">{{ $request->hospital_name }}, {{ $request->district }}</td>
                        <td class="p-3">{{ $request->needed_by_date->format('d M, Y') }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-0.5 rounded-full text-xs {{ $request->is_fulfilled ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $request->is_fulfilled ? 'Fulfilled' : 'Open' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2 text-xs">
                            <form action="{{ route('admin.blood-requests.fulfill', $request) }}" method="POST"
                                class="inline">
                                @csrf @method('PATCH')
                                <button
                                    class="text-green-600 hover:underline">{{ $request->is_fulfilled ? 'Mark Open' : 'Mark Fulfilled' }}</button>
                            </form>
                            <form action="{{ route('admin.blood-requests.destroy', $request) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $requests->links() }}</div>
@endsection
