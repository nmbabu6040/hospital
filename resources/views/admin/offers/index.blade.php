@extends('admin.layouts.app')

@section('title', 'Offers')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Offers</h2>
        <a href="{{ route('admin.offers.create') }}" class="btn-primary">+ Add Offer</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Start</th>
                    <th class="p-3">End</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offers as $offer)
                    <tr class="border-t">
                        <td class="p-3">{{ $offer->title }}</td>
                        <td class="p-3">{{ $offer->start_date?->format('d M, Y') }}</td>
                        <td class="p-3">{{ $offer->end_date?->format('d M, Y') }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.offers.edit', $offer) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No offers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $offers->links() }}</div>
@endsection
