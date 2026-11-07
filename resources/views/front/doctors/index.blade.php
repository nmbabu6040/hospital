@extends('layouts.app')

@section('title', __('site.doctors'))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6">{{ __('site.doctors') }}</h1>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-lg shadow-sm mb-8">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
                class="border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand">

            <select name="department" class="border border-gray-200 rounded-md px-3 py-2">
                <option value="">All Departments</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}</option>
                @endforeach
            </select>

            <select name="hospital" class="border border-gray-200 rounded-md px-3 py-2">
                <option value="">All Hospitals</option>
                @foreach ($hospitals as $hosp)
                    <option value="{{ $hosp->id }}" {{ request('hospital') == $hosp->id ? 'selected' : '' }}>
                        {{ $hosp->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary">{{ __('site.submit') }}</button>
        </form>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($doctors as $doctor)
                <a href="{{ route('doctors.show', $doctor) }}" class="card">
                    <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/300x300?text=' . urlencode($doctor->name) }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $doctor->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-sm">{{ $doctor->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $doctor->designation }}</p>
                        <p class="text-xs text-brand mt-1">{{ $doctor->department?->name }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">No doctors found.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $doctors->links() }}
        </div>
    </section>
@endsection
