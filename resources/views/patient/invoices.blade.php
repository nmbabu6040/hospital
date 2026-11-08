@extends('patient.layouts.app')

@section('title', 'My Invoices')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Invoice No</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr class="border-t">
                        <td class="p-3">{{ $invoice->invoice_no }}</td>
                        <td class="p-3">{{ $invoice->invoice_date->format('d M, Y') }}</td>
                        <td class="p-3">Tk {{ number_format($invoice->total, 2) }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($invoice->payment_status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">কোনো ইনভয়েস নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $invoices->links() }}</div>
@endsection
