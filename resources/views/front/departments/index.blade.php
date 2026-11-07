@extends('layouts.app')

@section('title', __('site.departments'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">{{ __('site.departments') }}</h1>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach ($departments as $department)
                <a href="{{ route('departments.show', $department) }}" class="card p-5 text-center group">
                    <div
                        class="w-14 h-14 mx-auto mb-3 rounded-full bg-brand/10 flex items-center justify-center group-hover:bg-brand transition">
                        <svg class="w-7 h-7 text-brand group-hover:text-white transition" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-sm">{{ $department->name }}</h3>
                </a>
            @endforeach
        </div>
    </section>
@endsection
