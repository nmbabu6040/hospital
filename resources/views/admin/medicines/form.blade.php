@extends('admin.layouts.app')

@section('title', $medicine->exists ? 'Edit Medicine' : 'Add Medicine')

@section('content')
    <form action="{{ $medicine->exists ? route('admin.medicines.update', $medicine) : route('admin.medicines.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($medicine->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Medicine Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $medicine->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Generic Name</label>
                <input type="text" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Manufacturer</label>
                <input type="text" name="manufacturer" value="{{ old('manufacturer', $medicine->manufacturer) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $medicine->category) }}"
                    placeholder="Tablet, Syrup, Injection" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Price (Tk) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $medicine->price) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="stock_quantity"
                    value="{{ old('stock_quantity', $medicine->stock_quantity ?? 0) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Low Stock Alert</label>
                <input type="number" name="low_stock_threshold"
                    value="{{ old('low_stock_threshold', $medicine->low_stock_threshold ?? 10) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Expiry Date</label>
                <input type="date" name="expiry_date"
                    value="{{ old('expiry_date', $medicine->expiry_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('description', $medicine->description) }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="requires_prescription" value="1"
                {{ old('requires_prescription', $medicine->requires_prescription) ? 'checked' : '' }}>
            Requires Prescription
        </label>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $medicine->is_active ?? true) ? 'checked' : '' }}>
            Active (Pharmacy পেজে দেখাবে)
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
