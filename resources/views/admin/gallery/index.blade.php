@extends('admin.layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Gallery Images</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn-primary">+ Add Image</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
        @forelse($images as $image)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-28 object-cover">
                <div class="p-2 text-center space-x-2 text-xs">
                    <a href="{{ route('admin.gallery.edit', $image) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="inline"
                        onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">No images uploaded yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $images->links() }}</div>
@endsection
