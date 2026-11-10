@extends('emails.layout')

@section('content')
    <p>আপনার Admin Panel লগইন ভেরিফিকেশন কোড:</p>
    <div style="text-align: center; margin: 25px 0;">
        <span
            style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: {{ \App\Models\Setting::get()->themePrimaryColor() }};">{{ $code }}</span>
    </div>
    <p style="font-size: 12px; color: #888;">এই কোডটি ১০ মিনিটের জন্য বৈধ। আপনি যদি এই লগইন অনুরোধ না করে থাকেন, এই ইমেইলটি
        উপেক্ষা করুন।</p>
@endsection
