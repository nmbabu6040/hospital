@extends('layouts.app')

@section('title', __('site.contact_us'))

@section('content')
    <section class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.contact_us') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 space-y-3 text-sm text-gray-700">
                    <p><strong>{{ __('site.address') }}:</strong> {{ $setting->address }}</p>
                    <p><strong>{{ __('site.phone') }}:</strong> {{ $setting->hotline }}</p>
                    <p><strong>{{ __('site.email') }}:</strong> {{ $setting->email }}</p>
                </div>

                @if ($setting->google_map_embed)
                    <div class="rounded-lg overflow-hidden shadow-sm [&_iframe]:w-full [&_iframe]:h-[400px]">
                        {!! $setting->google_map_embed !!}
                    </div>
                @else
                    <div
                        class="rounded-lg overflow-hidden shadow-sm bg-gray-100 dark:bg-gray-800 h-[300px] flex items-center justify-center text-gray-400 text-sm">
                        Map not configured yet.
                    </div>
                @endif
            </div>

            <div>
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST"
                    class="bg-white rounded-lg shadow-sm p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.full_name') }} <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.email') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.phone') }}</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.message') }} <span
                                class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">{{ __('site.send_message') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
