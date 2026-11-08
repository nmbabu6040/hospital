@extends('layouts.app')

@section('title', 'Ambulance Service')

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Ambulance Service</h1>
            <p class="text-gray-500 dark:text-gray-400">জরুরি প্রয়োজনে অ্যাম্বুলেন্স রিকোয়েস্ট করুন</p>
        </div>

        @if ($setting->hotline)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center mb-6">
                <p class="text-sm text-red-700 mb-2">চরম জরুরি অবস্থায়, ফর্ম পূরণের অপেক্ষা না করে সরাসরি কল করুন:</p>
                <a href="tel:{{ $setting->hotline }}" class="text-2xl font-bold text-red-600">📞 {{ $setting->hotline }}</a>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ambulance.store') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <label class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-md p-3 cursor-pointer">
                <input type="checkbox" name="is_emergency" value="1" class="w-5 h-5">
                <span class="text-sm font-medium text-red-700">🚨 এটি একটি জরুরি (Emergency) রিকোয়েস্ট</span>
            </label>

            <div>
                <label class="block text-sm font-medium mb-1">আপনার নাম <span class="text-red-500">*</span></label>
                <input type="text" name="requester_name" value="{{ old('requester_name', $patient->name ?? '') }}"
                    required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">ফোন নম্বর <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pickup Location <span class="text-red-500">*</span></label>
                <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" required
                    placeholder="বর্তমান ঠিকানা বা ল্যান্ডমার্ক"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Drop Location</label>
                <input type="text" name="drop_location" value="{{ old('drop_location') }}"
                    placeholder="হাসপাতালের নাম (ঐচ্ছিক)" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">অ্যাম্বুলেন্স টাইপ <span class="text-red-500">*</span></label>
                <select name="ambulance_type" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="Basic">Basic</option>
                    <option value="ICU">ICU Support</option>
                    <option value="Freezer">Freezer (মরদেহ পরিবহন)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">অতিরিক্ত তথ্য</label>
                <textarea name="additional_info" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('additional_info') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full">Request Ambulance</button>
        </form>
    </section>
@endsection
