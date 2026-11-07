@extends('admin.layouts.app')

@section('title', $concern->exists ? 'Edit Sister Concern' : 'Add Sister Concern')

@section('content')
    <form
        action="{{ $concern->exists ? route('admin.sister-concerns.update', $concern) : route('admin.sister-concerns.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($concern->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $concern->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Website URL</label>
            <input type="url" name="website_url" value="{{ old('website_url', $concern->website_url) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $concern->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Logo</label>
            @if ($concern->logo)
                <img src="{{ asset('storage/' . $concern->logo) }}" class="w-20 h-20 object-cover rounded mb-2">
            @endif
            <input type="file" name="logo" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
