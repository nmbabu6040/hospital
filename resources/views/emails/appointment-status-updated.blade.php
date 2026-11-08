@extends('emails.layout')

@section('content')
    <p>প্রিয় {{ $appointment->name }},</p>
    <p>আপনার অ্যাপয়েন্টমেন্টের স্ট্যাটাস আপডেট হয়েছে:</p>

    <div class="info-row"><strong>Doctor:</strong> {{ $appointment->doctor?->name ?? 'N/A' }}</div>
    <div class="info-row"><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</div>
    <div class="info-row"><strong>New Status:</strong>
        <span
            style="color: {{ $appointment->status == 'Confirmed' ? '#16a34a' : ($appointment->status == 'Cancelled' ? '#dc2626' : '#d97706') }}; font-weight: bold;">
            {{ $appointment->status }}
        </span>
    </div>

    @if ($appointment->status == 'Confirmed')
        <p style="margin-top: 20px;">আপনার অ্যাপয়েন্টমেন্ট কনফার্ম হয়েছে। নির্ধারিত সময়ে উপস্থিত থাকার অনুরোধ করা হলো।</p>
    @elseif($appointment->status == 'Cancelled')
        <p style="margin-top: 20px;">দুঃখিত, আপনার অ্যাপয়েন্টমেন্টটি বাতিল করা হয়েছে। নতুন অ্যাপয়েন্টমেন্টের জন্য আমাদের
            ওয়েবসাইট ভিজিট করুন অথবা হটলাইনে কল করুন।</p>
    @endif
@endsection
