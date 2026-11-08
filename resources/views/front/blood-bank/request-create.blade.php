@extends('layouts.app')

@section('title', 'Request Blood')

@section('content')
    <section class="max-w-xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-2 text-center">Request Blood</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-8">আপনার প্রয়োজনের তথ্য দিন, donor-রা দেখতে পাবেন।</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('blood-bank.request.store') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Patient Name <span class="text-red-500">*</span></label>
                <input type="text" name="patient_name" value="{{ old('patient_name') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div class="grid grid-cols-2 gap-5">
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
                <div>
                    <label class="block text-sm font-medium mb-1">Bags Needed <span class="text-red-500">*</span></label>
                    <input type="number" name="bags_needed" value="{{ old('bags_needed', 1) }}" min="1"
                        max="20" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Hospital Name <span class="text-red-500">*</span></label>
                    <input type="text" name="hospital_name" value="{{ old('hospital_name') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">District <span class="text-red-500">*</span></label>
                    <input type="text" name="district" value="{{ old('district') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Contact Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Needed By <span class="text-red-500">*</span></label>
                    <input type="date" name="needed_by_date" value="{{ old('needed_by_date') }}"
                        min="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Additional Info</label>
                <textarea name="additional_info" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('additional_info') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full">Post Blood Request</button>
        </form>
    </section>
@endsection
