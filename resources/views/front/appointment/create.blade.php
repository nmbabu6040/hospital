@extends('layouts.app')

@section('title', __('site.book_appointment'))

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.book_appointment') }}</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointment.store') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.full_name') }} <span
                        class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.phone') }} <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.select_doctor') }}</label>
                    <select name="doctor_id"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                        <option value="">-- {{ __('site.select_doctor') }} --</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $selectedDoctor) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} ({{ $doctor->department?->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.preferred_date') }} <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.message') }}</label>
                <textarea name="message" rows="4"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full">{{ __('site.submit') }}</button>
        </form>
    </section>
@endsection
