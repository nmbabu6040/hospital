@extends('patient.layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf @method('PUT')
            <h3 class="font-semibold border-b pb-2">Profile Information</h3>

            @if ($patient->avatar)
                <img src="{{ asset('storage/' . $patient->avatar) }}" class="w-20 h-20 rounded-full object-cover">
            @endif
            <div>
                <label class="block text-sm font-medium mb-1">Avatar</label>
                <input type="file" name="avatar" class="w-full border border-gray-200 rounded-md px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $patient->name) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gender</label>
                    <select name="gender" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                        <option value="">--</option>
                        <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Blood Group</label>
                    <input type="text" name="blood_group" value="{{ old('blood_group', $patient->blood_group) }}"
                        placeholder="A+" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $patient->address) }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <button type="submit" class="btn-primary">Update Profile</button>
        </form>

        <form action="{{ route('patient.password.update') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5 h-fit">
            @csrf @method('PUT')
            <h3 class="font-semibold border-b pb-2">Change Password</h3>

            <div>
                <label class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" name="current_password" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <button type="submit" class="btn-primary">Change Password</button>
        </form>

    </div>
@endsection
