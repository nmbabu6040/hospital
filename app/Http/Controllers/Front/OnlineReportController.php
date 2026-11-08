<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OnlineReport;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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

    public function download(OnlineReport $onlineReport)
    {
        abort_unless($onlineReport->report_file, 404);

        return response()->download(storage_path('app/public/' . $onlineReport->report_file));
    }

    public function generatedPdf(OnlineReport $onlineReport)
    {
        abort_unless($onlineReport->hasGeneratedReport(), 404);

        $onlineReport->load('items');
        $setting = Setting::get();

        $qrData = 'Report ID: ' . $onlineReport->report_id . "\n"
            . 'Patient: ' . $onlineReport->patient_name . "\n"
            . 'Phone: ' . $onlineReport->phone . "\n"
            . 'Verify at: ' . route('online-report.index');

        $qrCodeSvg = QrCode::format('svg')->size(120)->margin(1)->generate($qrData);
        $qrCodeBase64 = base64_encode($qrCodeSvg);

        $pdf = Pdf::loadView('front.online-report.pdf-letterhead', compact('onlineReport', 'setting', 'qrCodeBase64'))
            ->setPaper('a4', 'portrait');

        $fontDir = storage_path('fonts');
        if (File::exists($fontDir . '/NotoSansBengali-Regular.ttf')) {
            $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
            $fontMetrics->registerFont(
                ['family' => 'notosansbengali', 'style' => 'normal', 'weight' => 'normal'],
                $fontDir . '/NotoSansBengali-Regular.ttf'
            );
            $fontMetrics->registerFont(
                ['family' => 'notosansbengali', 'style' => 'normal', 'weight' => 'bold'],
                $fontDir . '/NotoSansBengali-Bold.ttf'
            );
        }

        return $pdf->stream('Report-' . $onlineReport->report_id . '.pdf');
    }
}
