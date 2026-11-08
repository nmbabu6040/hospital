@extends('layouts.app')

@section('title', 'Register as Blood Donor')

@section('content')
    <section class="max-w-xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-2 text-center">Register as Blood Donor</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-8">আপনার তথ্য দিয়ে donor তালিকায় যুক্ত হোন।</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('blood-bank.register.store') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $patient->name ?? '') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Blood Group <span class="text-red-500">*</span></label>
                <select name="blood_group" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- Select --</option>
                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                        <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>
                            {{ $group }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">District <span class="text-red-500">*</span></label>
                    <input type="text" name="district" value="{{ old('district') }}" required placeholder="Dhaka"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Area</label>
                    <input type="text" name="area" value="{{ old('area') }}" placeholder="Dhanmondi"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Age</label>
                    <input type="number" name="age" value="{{ old('age') }}" min="18" max="65"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gender</label>
                    <select name="gender" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                        <option value="">--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Last Donation</label>
                    <input type="date" name="last_donation_date" value="{{ old('last_donation_date') }}"
                        max="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <button type="submit" class="btn-primary w-full">Register as Donor</button>
        </form>
    </section>
@endsection
