@extends('admin.layouts.app')

@section('title', $test->exists ? 'Edit Test' : 'Add Test')

@section('content')
    <form action="{{ $test->exists ? route('admin.tests.update', $test) : route('admin.tests.store') }}" method="POST"
        class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($test->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Test Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $test->name) }}" required
                placeholder="e.g. CBC, X-Ray Chest" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Price (৳) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $test->price) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Sample Type</label>
                <input type="text" name="sample_type" value="{{ old('sample_type', $test->sample_type) }}"
                    placeholder="e.g. Blood, Urine" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Report Time</label>
                <input type="text" name="report_time" value="{{ old('report_time', $test->report_time) }}"
                    placeholder="e.g. 24 hours" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $test->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Preparation Instructions</label>
            <textarea name="preparation" rows="3" placeholder="e.g. 8 ঘণ্টা খালি পেটে থাকতে হবে"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('preparation', $test->preparation) }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $test->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        @include('admin.partials.seo-fields', ['model' => $test])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
