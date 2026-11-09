@extends('layouts.app')

@section('title', $jobPosting->title)

@section('content')
    <section class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h1 class="text-2xl font-bold mb-2">{{ $jobPosting->title }}</h1>
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="text-xs bg-brand/10 text-brand px-2 py-1 rounded-full">{{ $jobPosting->job_type }}</span>
                <span
                    class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">{{ $jobPosting->department }}</span>
                <span class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">{{ $jobPosting->location }}</span>
                <span class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">{{ $jobPosting->vacancies }}
                    vacancy</span>
                @if ($jobPosting->salary_range)
                    <span
                        class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">{{ $jobPosting->salary_range }}</span>
                @endif
            </div>

            <p class="text-sm text-red-500 font-medium mb-5">Application Deadline:
                {{ $jobPosting->deadline->format('d M, Y') }}</p>

            <h3 class="font-semibold mb-2">Job Description</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-5 whitespace-pre-line">
                {{ $jobPosting->description }}</p>

            @if ($jobPosting->responsibilities)
                <h3 class="font-semibold mb-2">Responsibilities</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-5 whitespace-pre-line">
                    {{ $jobPosting->responsibilities }}</p>
            @endif

            @if ($jobPosting->requirements)
                <h3 class="font-semibold mb-2">Requirements</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ $jobPosting->requirements }}</p>
            @endif
        </div>

        @if ($jobPosting->isOpen())
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-lg mb-4">Apply for this Position</h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-5 text-sm">
                        {{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-5 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('career.apply', $jobPosting) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="applicant_name" placeholder="Full Name *" required
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm">
                        <input type="email" name="email" placeholder="Email *" required
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm">
                    </div>
                    <input type="text" name="phone" placeholder="Phone *" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm">

                    <div>
                        <label class="block text-sm font-medium mb-1">Upload CV (PDF/DOC, max 5MB) *</label>
                        <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required
                            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm">
                    </div>

                    <textarea name="cover_letter" rows="4" placeholder="Cover Letter (optional)"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm"></textarea>

                    <button type="submit" class="btn-primary w-full">Submit Application</button>
                </form>
            </div>
        @else
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 text-center text-amber-700">
                এই পদের জন্য আবেদনের সময়সীমা শেষ হয়ে গেছে।
            </div>
        @endif
    </section>
@endsection
