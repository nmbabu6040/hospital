@extends('admin.layouts.app')

@section('title', $doctor->exists ? 'Edit Doctor' : 'Add Doctor')

@section('content')
    <form action="{{ $doctor->exists ? route('admin.doctors.update', $doctor) : route('admin.doctors.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($doctor->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $doctor->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $doctor->designation) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Degree</label>
                <input type="text" name="degree" value="{{ old('degree', $doctor->degree) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Department</label>
                <select name="department_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- Select --</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Hospital</label>
                <select name="hospital_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- Select --</option>
                    @foreach ($hospitals as $hosp)
                        <option value="{{ $hosp->id }}"
                            {{ old('hospital_id', $doctor->hospital_id) == $hosp->id ? 'selected' : '' }}>
                            {{ $hosp->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (auth('admin')->user()->isSuperAdmin())
            <div>
                <label class="block text-sm font-medium mb-1">Branch</label>
                <select name="branch_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- Select Branch --</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old('branch_id', $doctor->branch_id) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="branch_id" value="{{ auth('admin')->user()->branch_id }}">
            <p class="text-xs text-gray-400">Branch: {{ auth('admin')->user()->branch?->name ?? 'Not Assigned' }}</p>
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Chamber Time</label>
            <input type="text" name="chamber_time" value="{{ old('chamber_time', $doctor->chamber_time) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Bio</label>
            <textarea name="bio" rows="4" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('bio', $doctor->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Photo</label>
            @if ($doctor->image)
                <img src="{{ asset('storage/' . $doctor->image) }}" class="w-20 h-20 rounded-full object-cover mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $doctor->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        @include('admin.partials.seo-fields', ['model' => $doctor])

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
