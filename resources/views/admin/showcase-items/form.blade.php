@extends('admin.layouts.app')

@section('title', $item->exists ? 'Edit Item' : 'Add Item')

@section('content')
    <form action="{{ $item->exists ? route('admin.showcase-items.update', $item) : route('admin.showcase-items.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="type" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="corporate" {{ $item->type == 'corporate' ? 'selected' : '' }}>Corporate Tie-up</option>
                <option value="award" {{ $item->type == 'award' ? 'selected' : '' }}>Award</option>
                <option value="csr" {{ $item->type == 'csr' ? 'selected' : '' }}>CSR</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input type="date" name="item_date" value="{{ old('item_date', $item->item_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image/Logo</label>
            @if ($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="h-16 mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
