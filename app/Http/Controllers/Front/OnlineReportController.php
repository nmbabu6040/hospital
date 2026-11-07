<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OnlineReport;
use Illuminate\Http\Request;

class OnlineReportController extends Controller
{
    public function index()
    {
        return view('front.online-report.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $report = OnlineReport::where('report_id', $request->report_id)
            ->where('phone', $request->phone)
            ->first();

        if (! $report) {
            return back()->withErrors(['report_id' => 'No report found matching this Report ID and Phone Number. অনুগ্রহ করে তথ্য যাচাই করে আবার চেষ্টা করুন।'])->withInput();
        }

        if ($report->status !== 'ready' || ! $report->report_file) {
            return back()->withErrors(['report_id' => 'আপনার রিপোর্ট এখনো প্রস্তুত হয়নি। অনুগ্রহ করে পরে আবার চেষ্টা করুন অথবা হটলাইনে যোগাযোগ করুন।'])->withInput();
        }

        return view('front.online-report.index', ['report' => $report]);
    }
}
