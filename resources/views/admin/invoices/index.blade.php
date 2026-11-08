@extends('admin.layouts.app')

@section('title', 'Invoices')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">All Invoices</h2>
        <a href="{{ route('admin.invoices.create') }}" class="btn-primary">+ Create Invoice</a>
    </div>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow-sm mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice no, patient, phone..."
            class="border border-gray-200 rounded-md px-3 py-2 text-sm">
        <select name="status" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
        </select>
        <button type="submit" class="btn-primary text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Invoice No</th>
                    <th class="p-3">Patient</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $invoice->invoice_no }}</td>
                        <td class="p-3">{{ $invoice->patient_name }}</td>
                        <td class="p-3">{{ $invoice->invoice_date->format('d M, Y') }}</td>
                        <td class="p-3 font-semibold">Tk {{ number_format($invoice->total, 2) }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                            {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-700' : ($invoice->payment_status == 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                                class="text-gray-600 hover:underline">View</a>
                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank"
                                class="text-green-600 hover:underline">PDF</a>
                            <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this invoice?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">কোনো ইনভয়েস নেই। "Create Invoice" দিয়ে
                            শুরু করো।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $invoices->links() }}</div>
@endsection
