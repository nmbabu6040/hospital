@extends('admin.layouts.app')

@section('title', 'Sister Concerns')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Sister Concerns</h2>
        <a href="{{ route('admin.sister-concerns.create') }}" class="btn-primary">+ Add Sister Concern</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Logo</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Website</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($concerns as $concern)
                    <tr class="border-t">
                        <td class="p-3"><img
                                src="{{ $concern->logo ? asset('storage/' . $concern->logo) : 'https://placehold.co/50x50' }}"
                                class="w-10 h-10 object-cover rounded"></td>
                        <td class="p-3">{{ $concern->name }}</td>
                        <td class="p-3">{{ $concern->website_url }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.sister-concerns.edit', $concern) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.sister-concerns.destroy', $concern) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No sister concerns found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $concerns->links() }}</div>
@endsection
