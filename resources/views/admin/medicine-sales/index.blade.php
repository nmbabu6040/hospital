@extends('admin.layouts.app')

@section('title', 'Medicine Sales')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Medicine Sales</h2>
        <div class="flex items-center gap-3">
            <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-semibold">
                Today: Tk {{ number_format($todayTotal, 2) }}
            </div>
            <a href="{{ route('admin.medicine-sales.create') }}" class="btn-primary">+ New Sale</a>
        </div>
    </div>

    <form method="GET" class="mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sale no, customer..."
            class="w-full md:w-80 border border-gray-200 rounded-md px-4 py-2 text-sm">
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Sale No</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Items</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Date</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr class="border-t">
                        <td class="p-3 font-mono text-xs">{{ $sale->sale_no }}</td>
                        <td class="p-3">{{ $sale->customer_name ?: 'Walk-in' }}</td>
                        <td class="p-3">{{ $sale->items->count() }} item(s)</td>
                        <td class="p-3 font-semibold">Tk {{ number_format($sale->grand_total, 2) }}</td>
                        <td class="p-3 text-gray-400">{{ $sale->created_at->format('d M, Y h:i A') }}</td>
                        <td class="p-3"><a href="{{ route('admin.medicine-sales.show', $sale) }}"
                                class="text-blue-600 hover:underline">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">No sales found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $sales->links() }}</div>
@endsection
