@extends('admin.layouts.app')

@section('title', $ambulance->exists ? 'Edit Ambulance' : 'Add Ambulance')

@section('content')
    <form action="{{ $ambulance->exists ? route('admin.ambulances.update', $ambulance) : route('admin.ambulances.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($ambulance->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Vehicle No <span class="text-red-500">*</span></label>
            <input type="text" name="vehicle_no" value="{{ old('vehicle_no', $ambulance->vehicle_no) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Driver Name</label>
                <input type="text" name="driver_name" value="{{ old('driver_name', $ambulance->driver_name) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Driver Phone</label>
                <input type="text" name="driver_phone" value="{{ old('driver_phone', $ambulance->driver_phone) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Type</label>
                <select name="type" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="Basic" {{ $ambulance->type == 'Basic' ? 'selected' : '' }}>Basic</option>
                    <option value="ICU" {{ $ambulance->type == 'ICU' ? 'selected' : '' }}>ICU</option>
                    <option value="Freezer" {{ $ambulance->type == 'Freezer' ? 'selected' : '' }}>Freezer</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="available" {{ $ambulance->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="on_duty" {{ $ambulance->status == 'on_duty' ? 'selected' : '' }}>On Duty</option>
                    <option value="maintenance" {{ $ambulance->status == 'maintenance' ? 'selected' : '' }}>Maintenance
                    </option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Branch</label>
            <select name="branch_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="">-- None --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $ambulance->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
