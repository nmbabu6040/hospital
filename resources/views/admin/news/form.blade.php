@extends('admin.layouts.app')

@section('title', $news->exists ? 'Edit News' : 'Add News')

@section('content')
    <form action="{{ $news->exists ? route('admin.news.update', $news) : route('admin.news.store') }}" method="POST"
        enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($news->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Published Date</label>
            <input type="date" name="published_at"
                value="{{ old('published_at', $news->published_at?->format('Y-m-d')) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="8" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            @if ($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        @include('admin.partials.seo-fields', ['model' => $news])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
