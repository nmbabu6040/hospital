@extends('admin.layouts.app')

@section('title', $journal->exists ? 'Edit Journal' : 'Add Journal')

@section('content')
    <form action="{{ $journal->exists ? route('admin.journals.update', $journal) : route('admin.journals.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($journal->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $journal->title) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">PDF File {{ $journal->exists ? '' : '*' }}</label>
            @if ($journal->pdf_file)
                <p class="text-xs text-gray-500 mb-2"><a href="{{ asset('storage/' . $journal->pdf_file) }}" target="_blank"
                        class="text-blue-600">Current PDF</a></p>
            @endif
            <input type="file" name="pdf_file" accept="application/pdf" {{ $journal->exists ? '' : 'required' }}
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
