@extends('layouts.app')

@section('title', __('site.accreditation'))

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.accreditation') }}</h1>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="mb-8">
                @forelse($accreditations as $accreditation)
                    @if ($accreditation->description)
                        <div class="text-center max-w-2xl mx-auto mb-4">
                            <h3 class="font-medium text-gray-700 mb-1">{{ $accreditation->name }}</p>
                                <h4 class="text-gray-600 leading-relaxed text-sm">{{ $accreditation->description }}</h4>
                        </div>
                    @endif
                    <div class="text-center">
                        <img src="{{ $accreditation->logo ? asset('storage/' . $accreditation->logo) : 'https://placehold.co/160x100?text=' . urlencode($accreditation->name) }}"
                            alt="{{ $accreditation->name }}" class="h-50 mx-auto mb-2" loading="lazy">
                        >
                    </div>
                @empty
                    <p class="text-gray-500">কোনো accreditation যোগ করা হয়নি।</p>
                @endforelse
            </div>

            {{-- @foreach ($accreditations as $accreditation)
                @if ($accreditation->description)
                    <div class="text-center max-w-2xl mx-auto mb-4">
                        <p class="font-medium text-sm text-gray-700 mb-1">{{ $accreditation->name }}</p>
                        <p class="text-gray-600 leading-relaxed text-sm">{{ $accreditation->description }}</p>
                    </div>
                @endif
            @endforeach --}}
        </div>
    </section>
@endsection
