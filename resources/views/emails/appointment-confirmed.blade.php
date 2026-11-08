@extends('emails.layout')

@section('content')
    <p>প্রিয় {{ $appointment->name }},</p>
    <p>আপনার অ্যাপয়েন্টমেন্ট রিকোয়েস্ট সফলভাবে জমা হয়েছে। বিস্তারিত নিচে দেওয়া হলো:</p>

    <div class="info-row"><strong>Doctor:</strong> {{ $appointment->doctor?->name ?? 'N/A' }}</div>
    <div class="info-row"><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</div>
    @if ($appointment->slot_time)
        <div class="info-row"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->slot_time)->format('h:i A') }}
        </div>
    @endif
    @if ($appointment->serial_no)
        <div class="info-row"><strong>Serial No:</strong> {{ $appointment->serial_no }}</div>
    @endif
    <div class="info-row"><strong>Status:</strong> {{ $appointment->status }}</div>

    <p style="margin-top: 20px;">আমরা শীঘ্রই আপনার সাথে যোগাযোগ করবো। যেকোনো প্রশ্নে কল করুন।</p>
@endsection
