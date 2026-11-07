@extends('layouts.app')

@section('title', 'Diagnostic Tests')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6">Diagnostic Tests</h1>

        <form method="GET" class="mb-8">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search a test by name..."
                class="w-full md:w-96 border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
        </form>

        <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Test Name</th>
                        <th class="p-3">Sample</th>
                        <th class="p-3">Report Time</th>
                        <th class="p-3">Price</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tests as $test)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $test->name }}</td>
                            <td class="p-3 text-gray-500 dark:text-gray-400">{{ $test->sample_type ?: '—' }}</td>
                            <td class="p-3 text-gray-500 dark:text-gray-400">{{ $test->report_time ?: '—' }}</td>
                            <td class="p-3 text-brand font-semibold">৳{{ number_format($test->price) }}</td>
                            <td class="p-3"><a href="{{ route('tests.show', $test) }}"
                                    class="text-blue-600 hover:underline">Details</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">কোনো টেস্ট পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">{{ $tests->links() }}</div>
    </section>
@endsection
