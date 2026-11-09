@extends('admin.layouts.app')

@section('title', $notice->exists ? 'Edit Notice' : 'Add Notice')

@section('content')
    <form action="{{ $notice->exists ? route('admin.notices.update', $notice) : route('admin.notices.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($notice->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $notice->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    @foreach (['Tender', 'Notice', 'Circular', 'Announcement'] as $cat)
                        <option value="{{ $cat }}" {{ $notice->category == $cat ? 'selected' : '' }}>
                            {{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Publish Date <span class="text-red-500">*</span></label>
                <input type="date" name="publish_date"
                    value="{{ old('publish_date', $notice->publish_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                    required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Expiry Date</label>
                <input type="date" name="expiry_date"
                    value="{{ old('expiry_date', $notice->expiry_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="5" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $notice->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Attachment (PDF/DOC)</label>
            @if ($notice->attachment_file)
                <p class="text-xs text-gray-500 mb-2"><a href="{{ asset('storage/' . $notice->attachment_file) }}"
                        target="_blank" class="text-blue-600">Current File</a></p>
            @endif
            <input type="file" name="attachment_file" accept=".pdf,.doc,.docx"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $notice->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
