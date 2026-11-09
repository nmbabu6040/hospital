@extends('layouts.app')

@section('title', 'Career')

@section('content')
    <section class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center">Career Opportunities</h1>
        <p class="text-gray-500 dark:text-gray-400 text-center mb-10">আমাদের টিমের সাথে যুক্ত হোন</p>

        <div class="space-y-4">
            @forelse($jobs as $job)
                <a href="{{ route('career.show', $job) }}" class="card p-5 block hover:shadow-md transition">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="font-semibold text-lg">{{ $job->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $job->department }} · {{ $job->location }}</p>
                            <div class="flex gap-2 mt-2">
                                <span
                                    class="text-xs bg-brand/10 text-brand px-2 py-1 rounded-full">{{ $job->job_type }}</span>
                                <span
                                    class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">{{ $job->vacancies }}
                                    vacancy</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Apply by</p>
                            <p class="text-sm font-medium text-red-500">{{ $job->deadline->format('d M, Y') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-center text-gray-500 py-16">বর্তমানে কোনো নিয়োগ বিজ্ঞপ্তি নেই।</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $jobs->links() }}</div>
    </section>
@endsection
