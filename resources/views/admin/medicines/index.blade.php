@extends('admin.layouts.app')

@section('title', 'Medicines')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Medicine Inventory</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.medicines.index', ['filter' => 'low_stock']) }}" class="btn-outline text-sm">⚠️ Low
                Stock</a>
            <a href="{{ route('admin.medicines.create') }}" class="btn-primary">+ Add Medicine</a>
        </div>
    </div>

    <form method="GET" class="mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicines..."
            class="w-full md:w-80 border border-gray-200 rounded-md px-4 py-2 text-sm">
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Expiry</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $medicine)
                    <tr class="border-t {{ $medicine->isExpired() ? 'bg-red-50' : '' }}">
                        <td class="p-3">{{ $medicine->name }}</td>
                        <td class="p-3 text-gray-500">{{ $medicine->category ?: '—' }}</td>
                        <td class="p-3">Tk {{ number_format($medicine->price, 2) }}</td>
                        <td class="p-3">
                            <span
                                class="{{ $medicine->isLowStock() ? 'text-red-600 font-semibold' : 'text-gray-700' }}">{{ $medicine->stock_quantity }}</span>
                            @if ($medicine->isLowStock())
                                <span class="text-xs text-red-500">⚠️ Low</span>
                            @endif
                        </td>
                        <td class="p-3">
                            @if ($medicine->expiry_date)
                                <span
                                    class="{{ $medicine->isExpired() ? 'text-red-600 font-semibold' : ($medicine->isExpiringSoon() ? 'text-amber-600' : 'text-gray-500') }}">
                                    {{ $medicine->expiry_date->format('d M, Y') }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.medicines.edit', $medicine) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">No medicines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $medicines->links() }}</div>
@endsection
