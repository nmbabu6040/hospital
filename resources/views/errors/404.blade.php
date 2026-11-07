@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-24 text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-brand/10 flex items-center justify-center">
            <svg class="w-12 h-12 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-3">404</h1>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-3">পেজটি খুঁজে পাওয়া যায়নি</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">আপনি যে পেজটি খুঁজছেন সেটি হয়তো সরিয়ে ফেলা হয়েছে, নাম পরিবর্তন
            হয়েছে, অথবা সাময়িকভাবে অনুপলব্ধ।</p>
        <div class="flex justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary">হোমপেজে ফিরে যান</a>
            <a href="{{ route('contact.index') }}" class="btn-outline">যোগাযোগ করুন</a>
        </div>
    </section>
@endsection
