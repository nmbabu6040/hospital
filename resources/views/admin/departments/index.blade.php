@extends('admin.layouts.app')

@section('title', 'Departments')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Departments</h2>
        <a href="{{ route('admin.departments.create') }}" class="btn-primary">+ Add Department</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Featured</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    <tr class="border-t">
                        <td class="p-3">{{ $department->name }}</td>
                        <td class="p-3">{{ $department->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="p-3">{{ $department->sort_order }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.departments.edit', $department) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.departments.destroy', $department) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete this department?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No departments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $departments->links() }}</div>
@endsection
