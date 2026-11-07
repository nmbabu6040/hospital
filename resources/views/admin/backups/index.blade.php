@extends('admin.layouts.app')

@section('title', 'Backups')

@section('content')

    @if (session('error'))
        <div
            class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-5">
        <div>
            <h2 class="text-lg font-semibold">Database & File Backups</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Database, app code, এবং uploaded ফাইলের zip ব্যাকআপ তৈরি
                করুন।</p>
        </div>

        <form action="{{ route('admin.backups.create') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <button type="submit" :disabled="loading" class="btn-primary flex items-center gap-2 disabled:opacity-60">
                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span x-text="loading ? 'Creating Backup...' : 'Create New Backup'"></span>
            </button>
        </form>
    </div>

    <div
        class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-md mb-6 text-sm dark:bg-amber-900/20 dark:border-amber-800 dark:text-amber-300">
        ⚠️ ব্যাকআপ তৈরি হতে কিছু সময় লাগতে পারে (ডাটা সাইজ অনুযায়ী)। পেজ রিফ্রেশ করলে প্রসেস বন্ধ হয়ে যাবে — অনুগ্রহ করে
        অপেক্ষা করুন।
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">File Name</th>
                    <th class="p-3">Size</th>
                    <th class="p-3">Created At</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                    <tr class="border-t">
                        <td class="p-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6.75 4.5v6m3.75-6v6M4.5 7.5h15M9.75 7.5V3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V7.5" />
                            </svg>
                            {{ $backup['name'] }}
                        </td>
                        <td class="p-3">{{ $backup['size'] }}</td>
                        <td class="p-3">{{ $backup['date'] }}</td>
                        <td class="p-3 space-x-3">
                            <a href="{{ route('admin.backups.download', $backup['name']) }}"
                                class="text-blue-600 hover:underline">Download</a>
                            <form action="{{ route('admin.backups.destroy', $backup['name']) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete this backup permanently?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">কোনো ব্যাকআপ পাওয়া যায়নি। "Create New
                            Backup" বাটনে ক্লিক করে প্রথম ব্যাকআপ তৈরি করুন।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
