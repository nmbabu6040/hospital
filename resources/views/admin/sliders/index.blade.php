@extends('admin.layouts.app')

@section('title', 'Sliders')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Hero Sliders</h2>
        <a href="{{ route('admin.sliders.create') }}" class="btn-primary">+ Add Slider</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @forelse($sliders as $slider)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $slider->image) }}" class="w-full h-36 object-cover">
                <div class="p-3">
                    <p class="font-medium text-sm">{{ $slider->title ?? '—' }}</p>
                    <p class="text-xs text-gray-400">Order: {{ $slider->sort_order }}</p>
                    <div class="mt-2 space-x-2 text-xs">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="inline"
                            onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">No sliders yet.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $sliders->links() }}</div>
@endsection
