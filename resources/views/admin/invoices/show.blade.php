@extends('admin.layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_no)

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Invoice {{ $invoice->invoice_no }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank" class="btn-primary text-sm">📄 Download
                PDF</a>
            @if ($invoice->payment_status !== 'paid')
                <a href="{{ route('payment.invoice', $invoice) }}" class="btn-primary text-sm" target="_blank">💳 Pay
                    Online</a>
            @endif
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn-outline text-sm">Edit</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 max-w-2xl">
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div><span class="text-gray-400">Patient:</span> <strong>{{ $invoice->patient_name }}</strong></div>
            <div><span class="text-gray-400">Phone:</span> {{ $invoice->phone }}</div>
            <div><span class="text-gray-400">Date:</span> {{ $invoice->invoice_date->format('d M, Y') }}</div>
            <div><span class="text-gray-400">Status:</span>
                <span
                    class="px-2 py-0.5 rounded-full text-xs {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ ucfirst($invoice->payment_status) }}
                </span>
            </div>
        </div>

        <table class="w-full text-sm mb-6">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-2">Item</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->item_name }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">Tk {{ number_format($item->unit_price, 2) }}</td>
                        <td class="p-2">Tk {{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right space-y-1 text-sm">
            <p>Subtotal: Tk {{ number_format($invoice->subtotal, 2) }}</p>
            <p>Discount: Tk {{ number_format($invoice->discount, 2) }}</p>
            <p class="text-lg font-bold">Total: Tk {{ number_format($invoice->total, 2) }}</p>
        </div>
    </div>
@endsection
