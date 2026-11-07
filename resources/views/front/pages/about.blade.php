@extends('layouts.app')

@section('title', __('site.about'))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.about') }}</h1>

        <div class="bg-white rounded-lg shadow-sm p-6">
            @if ($aboutContent->about_image)
                <img src="{{ asset('storage/' . $aboutContent->about_image) }}"
                    class="w-full md:w-full h-80 object-cover rounded-lg mb-6 md:mb-0" loading="lazy" alt="About">
            @endif
            <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                {{ $aboutContent->about_text ?: 'এই মুহূর্তে কোনো তথ্য যোগ করা হয়নি।' }}
            </div>
        </div>

        @if ($aboutContent->patients_count || $aboutContent->staff_count || $aboutContent->doctors_count)
            <div class="grid grid-cols-3 gap-4 text-center mt-8">
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->patients_count) }}+</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.patients') }}</p>
                </div>
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->staff_count) }}+</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.staff') }}</p>
                </div>
                <div class="bg-brand/5 rounded-lg p-6">
                    <p class="text-3xl font-bold text-brand">{{ number_format($aboutContent->doctors_count) }}+</p>
                    <p class="text-sm text-gray-600 mt-1">{{ __('site.expert_doctors') }}</p>
                </div>
            </div>
        @endif
    </section>
@endsection
