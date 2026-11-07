@extends('layouts.app')

@section('title', $department->meta_title ?: $department->name)
@section('meta_description', $department->meta_description ?: Str::limit(strip_tags($department->description), 150))

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ $department->name }}</h1>
            <p class="text-gray-600 leading-relaxed mb-4">{{ $department->description }}</p>

            @if ($department->services)
                <h2 class="font-semibold text-lg mt-6 mb-2">Services</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $department->services }}</p>
            @endif
        </div>

        <h2 class="text-xl font-bold mb-6">Doctors in this Department</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($doctors as $doctor)
                <a href="{{ route('doctors.show', $doctor) }}" class="card">
                    <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : 'https://placehold.co/300x300?text=' . urlencode($doctor->name) }}"
                        class="w-full h-48 object-cover" loading="lazy" alt="{{ $doctor->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-sm">{{ $doctor->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $doctor->designation }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-gray-500">No doctors assigned to this department yet.</p>
            @endforelse
        </div>
    </section>
@endsection
