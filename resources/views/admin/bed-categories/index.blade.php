@extends('admin.layouts.app')

@section('title', 'Bed Availability Management')

@section('content')
    <h2 class="text-lg font-semibold mb-5">Bed Availability Management</h2>

    @foreach ($hospitals as $hospital)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-700 mb-4">{{ $hospital->name }}</h3>

            <form action="{{ route('admin.bed-categories.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5 items-end">
                @csrf
                <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Ward Name</label>
                    <input type="text" name="ward_name" placeholder="e.g. ICU, Cabin" required
                        class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Total Beds</label>
                    <input type="number" name="total_beds" min="0" required
                        class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Available Beds</label>
                    <input type="number" name="available_beds" min="0" required
                        class="w-full border border-gray-200 rounded-md px-2 py-2 text-sm">
                </div>
                <button type="submit" class="btn-primary text-sm">+ Add Ward</button>
            </form>

            <div class="space-y-2">
                @forelse($hospital->bedCategories as $category)
                    <div class="flex items-center gap-3 bg-gray-50 rounded-md px-4 py-3">
                        <span class="text-sm font-medium flex-1">{{ $category->ward_name }}</span>
                        <form action="{{ route('admin.bed-categories.update', $category) }}" method="POST"
                            class="flex items-center gap-2">
                            @csrf @method('PUT')
                            <input type="number" name="total_beds" value="{{ $category->total_beds }}" min="0"
                                class="w-20 border border-gray-200 rounded-md px-2 py-1 text-xs" placeholder="Total">
                            <input type="number" name="available_beds" value="{{ $category->available_beds }}"
                                min="0" class="w-20 border border-gray-200 rounded-md px-2 py-1 text-xs"
                                placeholder="Available">
                            <button type="submit" class="text-blue-600 text-xs hover:underline">Update</button>
                        </form>
                        <form action="{{ route('admin.bed-categories.destroy', $category) }}" method="POST"
                            onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-xs hover:underline">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">No ward data added yet.</p>
                @endforelse
            </div>
        </div>
    @endforeach
@endsection
