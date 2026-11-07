@extends('admin.layouts.app')

@section('title', 'Accreditations')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Accreditations</h2>
        <a href="{{ route('admin.accreditations.create') }}" class="btn-primary">+ Add Accreditation</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Logo</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accreditations as $accreditation)
                    <tr class="border-t">
                        <td class="p-3"><img
                                src="{{ $accreditation->logo ? asset('storage/' . $accreditation->logo) : 'https://placehold.co/60x40' }}"
                                class="h-10"></td>
                        <td class="p-3">{{ $accreditation->name }}</td>
                        <td class="p-3">{{ $accreditation->sort_order }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.accreditations.edit', $accreditation) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.accreditations.destroy', $accreditation) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No accreditations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $accreditations->links() }}</div>
@endsection
