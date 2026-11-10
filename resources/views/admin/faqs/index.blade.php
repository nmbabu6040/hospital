@extends('admin.layouts.app')

@section('title', 'FAQs')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">FAQ Management</h2>
        <a href="{{ route('admin.faqs.create') }}" class="btn-primary">+ Add FAQ</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Question</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr class="border-t">
                        <td class="p-3">{{ Str::limit($faq->question, 60) }}</td>
                        <td class="p-3">{{ $faq->category ?: 'General' }}</td>
                        <td class="p-3">{{ $faq->sort_order }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $faq->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No FAQs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $faqs->links() }}</div>
@endsection
