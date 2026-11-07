@extends('admin.layouts.app')

@section('title', $page->exists ? 'Edit Page' : 'Add Page')

@section('content')
    <form action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST"
        enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($page->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                placeholder="e.g. Privacy Policy" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">URL Slug (ফাঁকা রাখলে টাইটেল থেকে অটো তৈরি হবে)</label>
            <div class="flex items-center">
                <span
                    class="text-gray-400 text-sm px-3 py-2.5 bg-gray-50 border border-r-0 border-gray-200 rounded-l-md">/page/</span>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="privacy-policy"
                    class="w-full border border-gray-200 rounded-r-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Featured Image (ঐচ্ছিক)</label>
            @if ($page->featured_image)
                <img src="{{ asset('storage/' . $page->featured_image) }}" class="w-full h-32 object-cover rounded mb-2">
            @endif
            <input type="file" name="featured_image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="10" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('content', $page->content) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">সাধারণ টেক্সট লিখুন, নতুন লাইন অটো প্যারাগ্রাফ হয়ে যাবে।</p>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-2">SEO</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Meta Title (ফাঁকা রাখলে Page Title ব্যবহার হবে)</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Meta Description</label>
            <textarea name="meta_description" rows="2" maxlength="500"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('meta_description', $page->meta_description) }}</textarea>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-2">Menu Settings</h3>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="show_in_menu" value="1" id="show-in-menu"
                {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
            এই পেজটি মেনুতে দেখাও
        </label>

        <div>
            <label class="block text-sm font-medium mb-1">Menu Location</label>
            <select name="menu_location" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="none"
                    {{ old('menu_location', $page->menu_location ?? 'none') == 'none' ? 'selected' : '' }}>None</option>
                <option value="header" {{ old('menu_location', $page->menu_location) == 'header' ? 'selected' : '' }}>Header
                    Menu</option>
                <option value="footer" {{ old('menu_location', $page->menu_location) == 'footer' ? 'selected' : '' }}>
                    Footer Menu</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 0) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
            Active (অফ থাকলে পেজটা ভিজিটররা দেখতে পারবে না — 404 দেখাবে)
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
