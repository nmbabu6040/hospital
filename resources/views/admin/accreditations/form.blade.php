@extends('admin.layouts.app')

@section('title', $accreditation->exists ? 'Edit Accreditation' : 'Add Accreditation')

@section('content')
    <form
        action="{{ $accreditation->exists ? route('admin.accreditations.update', $accreditation) : route('admin.accreditations.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($accreditation->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $accreditation->name) }}" required
                placeholder="e.g. NABH, CAP" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $accreditation->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Logo</label>
            @if ($accreditation->logo)
                <img src="{{ asset('storage/' . $accreditation->logo) }}" class="h-16 mb-2">
            @endif
            <input type="file" name="logo" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $accreditation->sort_order ?? 0) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
