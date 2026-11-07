@extends('admin.layouts.app')

@section('title', 'About Content')

@section('content')
    <form action="{{ route('admin.about-content.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @method('PUT')

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4">MD's Message</h3>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">MD Name</label>
                <input type="text" name="md_name" value="{{ old('md_name', $aboutContent->md_name) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Designation</label>
                <input type="text" name="md_designation"
                    value="{{ old('md_designation', $aboutContent->md_designation) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">MD's Message</label>
            <textarea name="md_message" rows="5" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('md_message', $aboutContent->md_message) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">MD's Photo</label>
            @if ($aboutContent->md_image)
                <img src="{{ asset('storage/' . $aboutContent->md_image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="md_image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">About Us Page</h3>

        <div>
            <label class="block text-sm font-medium mb-1">About Text</label>
            <textarea name="about_text" rows="6" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('about_text', $aboutContent->about_text) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">About Image</label>
            @if ($aboutContent->about_image)
                <img src="{{ asset('storage/' . $aboutContent->about_image) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="about_image" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Statistics (Home Page-এ দেখাবে)</h3>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patients Served</label>
                <input type="number" name="patients_count"
                    value="{{ old('patients_count', $aboutContent->patients_count) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Medical Staff</label>
                <input type="number" name="staff_count" value="{{ old('staff_count', $aboutContent->staff_count) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Expert Doctors</label>
                <input type="number" name="doctors_count" value="{{ old('doctors_count', $aboutContent->doctors_count) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
