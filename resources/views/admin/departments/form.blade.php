@extends('admin.layouts.app')

@section('title', $department->exists ? 'Edit Department' : 'Add Department')

@section('content')
    <form
        action="{{ $department->exists ? route('admin.departments.update', $department) : route('admin.departments.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($department->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $department->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $department->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Services (one per line)</label>
            <textarea name="services" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('services', $department->services) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            @if ($department->image)
                <img src="{{ asset('storage/' . $department->image) }}" class="w-20 h-20 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $department->sort_order ?? 0) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_featured" value="1"
                {{ old('is_featured', $department->is_featured) ? 'checked' : '' }}>
            Featured (shows on homepage)
        </label>

        @include('admin.partials.seo-fields', ['model' => $department])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
