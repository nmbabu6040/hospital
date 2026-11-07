@extends('admin.layouts.app')

@section('title', $package->exists ? 'Edit Package' : 'Add Package')

@section('content')
    <form action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($package->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $package->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Price (৳) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $package->price) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $package->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Select Individual Tests (উপরে Tests মডিউল থেকে যোগ করা টেস্ট এখানে
                দেখাবে)</label>
            <div class="border border-gray-200 rounded-md p-3 max-h-64 overflow-y-auto space-y-1">
                @forelse($tests as $test)
                    <label
                        class="flex items-center gap-2 text-sm py-1 hover:bg-gray-50 dark:hover:bg-gray-800 px-2 rounded">
                        <input type="checkbox" name="test_ids[]" value="{{ $test->id }}"
                            {{ (old('test_ids') ? in_array($test->id, old('test_ids')) : $package->exists && $package->individualTests->contains($test->id)) ? 'checked' : '' }}>
                        {{ $test->name }} <span class="text-gray-400 text-xs">(৳{{ number_format($test->price) }})</span>
                    </label>
                @empty
                    <p class="text-sm text-gray-400">কোনো Test নেই। আগে Tests মডিউল থেকে টেস্ট যোগ করুন।</p>
                @endforelse
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Legacy Tests (one per line — ঐচ্ছিক, উপরের সিলেক্ট না করলেও এটা
                দিয়ে কাজ চলবে)</label>
            <textarea name="tests" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('tests', $package->tests) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            @if ($package->image)
                <img src="{{ asset('storage/' . $package->image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        @include('admin.partials.seo-fields', ['model' => $package])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
