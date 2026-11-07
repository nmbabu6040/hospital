@extends('layouts.app')

@section('title', __('site.md_message'))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.md_message') }}</h1>

        <div class="bg-white rounded-lg shadow-sm p-6 md:flex gap-8">
            <img src="{{ $aboutContent->md_image ? asset('storage/' . $aboutContent->md_image) : 'https://placehold.co/300x350?text=MD' }}"
                class="w-full md:w-80 h-100 object-cover rounded-lg mb-6 md:mb-0" loading="lazy" alt="MD">
            <div>
                <div class="text-gray-600 leading-relaxed mb-4 whitespace-pre-line">
                    {{ $aboutContent->md_message ?: 'এই মুহূর্তে কোনো বার্তা যোগ করা হয়নি।' }}
                </div>
                @if ($aboutContent->md_name)
                    <p class="font-semibold mt-6">- {{ $aboutContent->md_name }}</p>
                    @if ($aboutContent->md_designation)
                        <p class="text-sm text-gray-500">{{ $aboutContent->md_designation }}</p>
                    @endif
                @else
                    <p class="font-semibold mt-6">- Managing Director</p>
                @endif
            </div>
        </div>
    </section>
@endsection
