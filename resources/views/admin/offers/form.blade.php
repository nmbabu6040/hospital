@extends('admin.layouts.app')

@section('title', $offer->exists ? 'Edit Offer' : 'Add Offer')

@section('content')
    <form action="{{ $offer->exists ? route('admin.offers.update', $offer) : route('admin.offers.store') }}" method="POST"
        enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($offer->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $offer->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Start Date</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $offer->start_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $offer->end_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $offer->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            @if ($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        @include('admin.partials.seo-fields', ['model' => $offer])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
