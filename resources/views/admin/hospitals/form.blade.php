@extends('admin.layouts.app')

@section('title', $hospital->exists ? 'Edit Hospital' : 'Add Hospital')

@section('content')
    <form action="{{ $hospital->exists ? route('admin.hospitals.update', $hospital) : route('admin.hospitals.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($hospital->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $hospital->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $hospital->phone) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $hospital->email) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $hospital->address) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $hospital->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Facilities (one per line)</label>
            <textarea name="facilities" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('facilities', $hospital->facilities) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Google Map Embed (iframe code)</label>
            <textarea name="map_embed" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('map_embed', $hospital->map_embed) }}</textarea>
        </div>

        @include('admin.partials.map-picker', ['model' => $hospital])

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            @if ($hospital->image)
                <img src="{{ asset('storage/' . $hospital->image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $hospital->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        @include('admin.partials.seo-fields', ['model' => $hospital])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
