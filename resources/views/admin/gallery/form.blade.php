@extends('admin.layouts.app')

@section('title', $image->exists ? 'Edit Image' : 'Add Image')

@section('content')
    <form action="{{ $image->exists ? route('admin.gallery.update', $image) : route('admin.gallery.store') }}" method="POST"
        enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($image->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $image->title) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image {{ $image->exists ? '' : '*' }}</label>
            @if ($image->image)
                <img src="{{ asset('storage/' . $image->image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" {{ $image->exists ? '' : 'required' }}
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
