@extends('admin.layouts.app')

@section('title', 'Online Payments')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Online Payments</h2>
        <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-semibold">
            Total Received: Tk {{ number_format($totalReceived, 2) }}
        </div>
    </div>

    <div class="flex gap-2 mb-5 text-sm">
        <a href="{{ route('admin.payments.index') }}"
            class="px-3 py-1.5 rounded-md {{ !request('status') ? 'bg-brand text-white' : 'bg-gray-100' }}">All</a>
        <a href="{{ route('admin.payments.index', ['status' => 'success']) }}"
            class="px-3 py-1.5 rounded-md {{ request('status') == 'success' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">Success</a>
        <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}"
            class="px-3 py-1.5 rounded-md {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100' }}">Pending</a>
        <a href="{{ route('admin.payments.index', ['status' => 'failed']) }}"
            class="px-3 py-1.5 rounded-md {{ request('status') == 'failed' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">Failed</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Transaction ID</th>
                    <th class="p-3">Payer</th>
                    <th class="p-3">For</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-t">
                        <td class="p-3 font-mono text-xs">{{ $payment->transaction_id }}</td>
                        <td class="p-3">{{ $payment->payer_name }}</td>
                        <td class="p-3">{{ $payment->package?->name ?? ($payment->invoice?->invoice_no ?? '—') }}</td>
                        <td class="p-3">Tk {{ number_format($payment->amount, 2) }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                            {{ $payment->status == 'success' ? 'bg-green-100 text-green-700' : ($payment->status == 'failed' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-gray-400">{{ $payment->created_at->format('d M, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">কোনো পেমেন্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $payments->links() }}</div>
@endsection
