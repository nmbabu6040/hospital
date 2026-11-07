@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-24 text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-3">403</h1>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-3">অ্যাক্সেস নিষিদ্ধ</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">{{ $exception->getMessage() ?: 'এই পেজ দেখার অনুমতি আপনার নেই।' }}
        </p>
        <a href="{{ route('home') }}" class="btn-primary">হোমপেজে ফিরে যান</a>
    </section>
@endsection
