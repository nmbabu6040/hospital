<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OnlineReport;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
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

        if ($report->status !== 'ready' || (! $report->report_file && ! $report->hasGeneratedReport())) {
            return back()->withErrors(['report_id' => 'আপনার রিপোর্ট এখনো প্রস্তুত হয়নি। অনুগ্রহ করে পরে আবার চেষ্টা করুন অথবা হটলাইনে যোগাযোগ করুন।'])->withInput();
        }

        return view('front.online-report.index', ['report' => $report]);
    }

    /**
     * Admin-এর আপলোড করা আসল PDF ডাউনলোড করে, যদি থাকে।
     */
    public function download(OnlineReport $onlineReport)
    {
        abort_unless($onlineReport->report_file, 404);

        return response()->download(storage_path('app/public/' . $onlineReport->report_file));
    }

    /**
     * ম্যানুয়ালি এন্ট্রি দেওয়া টেস্ট রেজাল্ট থেকে Labaid-স্টাইল letterhead PDF জেনারেট করে।
     */
    public function generatedPdf(OnlineReport $onlineReport)
    {
        abort_unless($onlineReport->hasGeneratedReport(), 404);

        $onlineReport->load('items');
        $setting = Setting::get();

        $pdf = Pdf::loadView('front.online-report.pdf-letterhead', compact('onlineReport', 'setting'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Report-' . $onlineReport->report_id . '.pdf');
    }
}
