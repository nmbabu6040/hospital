@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-semibold">Newsletter Subscribers</h2>
            <p class="text-sm text-gray-500">Total Active: {{ $totalActive }}</p>
        </div>
        <a href="{{ route('admin.newsletter-subscribers.export') }}" class="btn-primary">📥 Export CSV</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Email</th>
                    <th class="p-3">Subscribed On</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr class="border-t">
                        <td class="p-3">{{ $subscriber->email }}</td>
                        <td class="p-3 text-gray-400">{{ $subscriber->created_at->format('d M, Y') }}</td>
                        <td class="p-3">
                            <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST"
                                onsubmit="return confirm('Remove?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500">No subscribers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $subscribers->links() }}</div>
@endsection
