<?php

namespace App\Mail;

use App\Models\OnlineReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnlineReport $report) {}

    public function build()
    {
        return $this->subject('Your Lab Report is Ready - ' . config('app.name'))
            ->view('emails.report-ready');
    }
}
