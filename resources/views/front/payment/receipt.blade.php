@extends('layouts.app')

@section('title', 'Payment Receipt')

@section('content')
    <section class="max-w-xl mx-auto px-4 py-12">

        @if ($payment->status === 'success')
            <div class="text-center mb-6">
                <svg class="w-16 h-16 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="text-2xl font-bold text-green-700">Payment Successful!</h1>
            </div>
        @else
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-red-600">Payment {{ ucfirst($payment->status) }}</h1>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm p-6 space-y-3 text-sm">
            <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Transaction
                    ID</span><strong>{{ $payment->transaction_id }}</strong></div>
            <div class="flex justify-between border-b pb-2"><span
                    class="text-gray-500">Name</span><strong>{{ $payment->payer_name }}</strong></div>
            <div class="flex justify-between border-b pb-2"><span class="text-gray-500">Amount</span><strong>Tk
                    {{ number_format($payment->amount, 2) }}</strong></div>
            <div class="flex justify-between border-b pb-2"><span
                    class="text-gray-500">Method</span><strong>{{ $payment->payment_method ?: 'N/A' }}</strong></div>
            <div class="flex justify-between"><span
                    class="text-gray-500">Date</span><strong>{{ $payment->paid_at?->format('d M, Y h:i A') ?? $payment->created_at->format('d M, Y h:i A') }}</strong>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="btn-primary">হোমপেজে ফিরে যান</a>
        </div>
    </section>
@endsection
