@extends('admin.layouts.app')

@section('title', 'Journals')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Journals</h2>
        <a href="{{ route('admin.journals.create') }}" class="btn-primary">+ Add Journal</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">File</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($journals as $journal)
                    <tr class="border-t">
                        <td class="p-3">{{ $journal->title }}</td>
                        <td class="p-3"><a href="{{ asset('storage/' . $journal->pdf_file) }}" target="_blank"
                                class="text-blue-600 hover:underline">View PDF</a></td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.journals.edit', $journal) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.journals.destroy', $journal) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-5 text-center text-gray-500">No journals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $journals->links() }}</div>
@endsection
