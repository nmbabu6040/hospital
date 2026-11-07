@extends('admin.layouts.app')

@section('title', 'Tests')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Individual Tests</h2>
        <a href="{{ route('admin.tests.create') }}" class="btn-primary">+ Add Test</a>
    </div>

    <form method="GET" class="mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tests..."
            class="w-full md:w-80 border border-gray-200 rounded-md px-4 py-2 text-sm">
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Sample</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tests as $test)
                    <tr class="border-t">
                        <td class="p-3">{{ $test->name }}</td>
                        <td class="p-3">৳{{ number_format($test->price) }}</td>
                        <td class="p-3">{{ $test->sample_type ?: '—' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $test->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $test->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.tests.edit', $test) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this test?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No tests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $tests->links() }}</div>
@endsection
