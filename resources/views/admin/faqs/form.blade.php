@extends('admin.layouts.app')

@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')

@section('content')
    <form action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST"
        class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($faq->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Question <span class="text-red-500">*</span></label>
            <input type="text" name="question" value="{{ old('question', $faq->question) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Answer <span class="text-red-500">*</span></label>
            <textarea name="answer" rows="5" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $faq->category) }}"
                    placeholder="General, Appointment, Payment etc."
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
