@extends('admin.layouts.app')

@section('title', $slider->exists ? 'Edit Slider' : 'Add Slider')

@section('content')
    <form action="{{ $slider->exists ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($slider->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title (বড় হেডলাইন)</label>
            <input type="text" name="title" value="{{ old('title', $slider->title) }}"
                placeholder="Your Health, Our Priority" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Subtitle (ছোট লাইন, হেডলাইনের নিচে)</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description (ঐচ্ছিক, আরেকটু বিস্তারিত টেক্সট)</label>
            <textarea name="description" rows="2" maxlength="1000"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $slider->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order ?? 0) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-2">CTA Buttons (সর্বোচ্চ ২টা বাটন)</h3>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Button 1 Text</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $slider->cta_text) }}"
                    placeholder="Book Appointment" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Button 1 URL</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $slider->cta_url) }}"
                    placeholder="/book-appointment বা https://..."
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Button 2 Text (ঐচ্ছিক)</label>
                <input type="text" name="cta_text_2" value="{{ old('cta_text_2', $slider->cta_text_2) }}"
                    placeholder="Find a Doctor" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Button 2 URL (ঐচ্ছিক)</label>
                <input type="text" name="cta_url_2" value="{{ old('cta_url_2', $slider->cta_url_2) }}"
                    placeholder="/doctors" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <p class="text-xs text-gray-400">URL হিসেবে internal path (যেমন <code>/doctors</code>) অথবা পূর্ণ external লিংক
            (যেমন <code>https://example.com</code>) দুটোই দেওয়া যাবে।</p>

        <div>
            <label class="block text-sm font-medium mb-1">Image {{ $slider->exists ? '' : '*' }}</label>
            @if ($slider->image)
                <img src="{{ asset('storage/' . $slider->image) }}" class="w-full h-32 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" {{ $slider->exists ? '' : 'required' }}
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
