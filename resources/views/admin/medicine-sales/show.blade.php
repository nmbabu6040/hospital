@extends('admin.layouts.app')

@section('title', 'Sale ' . $medicineSale->sale_no)

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 max-w-xl">
        <h2 class="text-lg font-semibold mb-4">{{ $medicineSale->sale_no }}</h2>

        <div class="text-sm space-y-1 mb-5">
            <p><strong>Customer:</strong> {{ $medicineSale->customer_name ?: 'Walk-in' }}</p>
            <p><strong>Phone:</strong> {{ $medicineSale->customer_phone ?: '—' }}</p>
            <p><strong>Date:</strong> {{ $medicineSale->created_at->format('d M, Y h:i A') }}</p>
            <p><strong>Sold By:</strong> {{ $medicineSale->soldBy?->name ?? 'N/A' }}</p>
        </div>

        <table class="w-full text-sm mb-4">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-2">Medicine</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicineSale->items as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->medicine_name }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">Tk {{ number_format($item->unit_price, 2) }}</td>
                        <td class="p-2">Tk {{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right text-sm space-y-1">
            <p>Subtotal: Tk {{ number_format($medicineSale->total_amount, 2) }}</p>
            <p>Discount: Tk {{ number_format($medicineSale->discount, 2) }}</p>
            <p class="text-lg font-bold">Grand Total: Tk {{ number_format($medicineSale->grand_total, 2) }}</p>
        </div>
    </div>
@endsection
