@extends('emails.layout')

@section('content')
    <p>প্রিয় {{ $report->patient_name }},</p>
    <p>আপনার ল্যাব রিপোর্ট এখন প্রস্তুত। বিস্তারিত নিচে দেওয়া হলো:</p>

    <div class="info-row"><strong>Report ID:</strong> {{ $report->report_id }}</div>
    <div class="info-row"><strong>Report Date:</strong> {{ $report->report_date?->format('d M, Y') }}</div>

    <a href="{{ route('online-report.index') }}" class="btn">রিপোর্ট ডাউনলোড করুন</a>

    <p style="margin-top: 20px;">ওয়েবসাইটে গিয়ে আপনার Report ID ও ফোন নম্বর দিয়ে রিপোর্ট ডাউনলোড করতে পারবেন।</p>
@endsection
