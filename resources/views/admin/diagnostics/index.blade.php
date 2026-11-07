@extends('admin.layouts.app')

@section('title', 'Diagnostics')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Diagnostic Centers</h2>
        <a href="{{ route('admin.diagnostics.create') }}" class="btn-primary">+ Add Diagnostic Center</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Address</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diagnostics as $diagnostic)
                    <tr class="border-t">
                        <td class="p-3">{{ $diagnostic->name }}</td>
                        <td class="p-3">{{ Str::limit($diagnostic->address, 40) }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $diagnostic->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $diagnostic->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.diagnostics.edit', $diagnostic) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.diagnostics.destroy', $diagnostic) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete this diagnostic center?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No diagnostic centers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $diagnostics->links() }}</div>
@endsection
