@extends('admin.layouts.app')

@section('title', 'Notices')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Notice Board</h2>
        <a href="{{ route('admin.notices.create') }}" class="btn-primary">+ Add Notice</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Published</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notices as $notice)
                    <tr class="border-t">
                        <td class="p-3">{{ $notice->title }}</td>
                        <td class="p-3">{{ $notice->category }}</td>
                        <td class="p-3">{{ $notice->publish_date->format('d M, Y') }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $notice->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $notice->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.notices.edit', $notice) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No notices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $notices->links() }}</div>
@endsection
