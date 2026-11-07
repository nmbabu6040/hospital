@extends('admin.layouts.app')

@section('title', $branch->exists ? 'Edit Branch' : 'Add Branch')

@section('content')
    <form action="{{ $branch->exists ? route('admin.branches.update', $branch) : route('admin.branches.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($branch->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $branch->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $branch->address) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        @include('admin.partials.map-picker', ['model' => $branch])

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $branch->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
