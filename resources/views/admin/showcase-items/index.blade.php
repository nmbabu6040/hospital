@extends('admin.layouts.app')

@section('title', 'Showcase Content')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Showcase Content</h2>
        <a href="{{ route('admin.showcase-items.create', ['type' => $type]) }}" class="btn-primary">+ Add Item</a>
    </div>

    <div class="flex gap-2 mb-5 text-sm">
        <a href="{{ route('admin.showcase-items.index', ['type' => 'corporate']) }}"
            class="px-3 py-1.5 rounded-md {{ $type == 'corporate' ? 'bg-brand text-white' : 'bg-gray-100' }}">Corporate
            Tie-ups</a>
        <a href="{{ route('admin.showcase-items.index', ['type' => 'award']) }}"
            class="px-3 py-1.5 rounded-md {{ $type == 'award' ? 'bg-brand text-white' : 'bg-gray-100' }}">Awards</a>
        <a href="{{ route('admin.showcase-items.index', ['type' => 'csr']) }}"
            class="px-3 py-1.5 rounded-md {{ $type == 'csr' ? 'bg-brand text-white' : 'bg-gray-100' }}">CSR</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="p-3"><img
                                src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/60x40' }}"
                                class="h-10"></td>
                        <td class="p-3">{{ $item->title }}</td>
                        <td class="p-3">{{ $item->sort_order }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.showcase-items.edit', $item) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.showcase-items.destroy', $item) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
