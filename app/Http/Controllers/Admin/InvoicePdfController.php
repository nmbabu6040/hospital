<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoicePdfController extends Controller
{
    public function download(Invoice $invoice)
    {
        $invoice->load('items', 'hospital');
        $setting = Setting::get();

        $qrData = 'Invoice: ' . $invoice->invoice_no . "\n"
            . 'Patient: ' . $invoice->patient_name . "\n"
            . 'Total: Tk ' . number_format($invoice->total, 2) . "\n"
            . 'Date: ' . $invoice->invoice_date->format('d M, Y');

        $qrCodeBase64 = base64_encode(
            QrCode::format('svg')->size(100)->margin(1)->generate($qrData)
        );

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice', 'setting', 'qrCodeBase64'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Invoice-' . $invoice->invoice_no . '.pdf');
    }
}
