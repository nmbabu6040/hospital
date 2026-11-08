@extends('layouts.app')

@section('title', 'Video Consultation')

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-brand/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Video Consultation</h1>
            <p class="text-gray-500 dark:text-gray-400">ঘরে বসেই ডাক্তারের সাথে ভিডিও কলে কথা বলুন। নিচের ফর্মটি পূরণ করুন,
                আমরা আপনাকে মিটিং সময় ও লিংক জানিয়ে দেবো।</p>
        </div>

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

        <form action="{{ route('video-consultation.store') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">আপনার নাম <span class="text-red-500">*</span></label>
                <input type="text" name="patient_name" value="{{ old('patient_name', $patient->name ?? '') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">ফোন <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">ইমেইল</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">পছন্দের ডাক্তার</label>
                <select name="doctor_id"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                    <option value="">-- কোনো নির্দিষ্ট ডাক্তার নেই (যেকোনো) --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ old('doctor_id', $selectedDoctor) == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} ({{ $doctor->department?->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">পছন্দের তারিখ <span class="text-red-500">*</span></label>
                    <input type="date" name="preferred_date" value="{{ old('preferred_date') }}"
                        min="{{ date('Y-m-d') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">পছন্দের সময়</label>
                    <input type="text" name="preferred_time" value="{{ old('preferred_time') }}"
                        placeholder="e.g. Evening, 6-8 PM"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">সমস্যার সংক্ষিপ্ত বিবরণ</label>
                <textarea name="reason" rows="4"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">{{ old('reason') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full">Request Video Consultation</button>
        </form>
    </section>
@endsection
