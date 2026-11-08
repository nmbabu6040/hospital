<?php

namespace App\Services;

use App\Mail\AppointmentConfirmedMail;
use App\Mail\AppointmentStatusUpdatedMail;
use App\Mail\ReportReadyMail;
use App\Models\AdminNotification;
use App\Models\Appointment;
use App\Models\OnlineReport;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function newAppointment(string $patientName, ?int $branchId, string $link): void
    {
        AdminNotification::create([
            'type' => 'appointment',
            'title' => 'New Appointment Request',
            'body' => $patientName . ' একটি নতুন অ্যাপয়েন্টমেন্ট বুক করেছেন।',
            'link' => $link,
            'branch_id' => $branchId,
        ]);
    }

    public static function newMessage(string $senderName, string $link): void
    {
        AdminNotification::create([
            'type' => 'message',
            'title' => 'New Contact Message',
            'body' => $senderName . ' একটি নতুন মেসেজ পাঠিয়েছেন।',
            'link' => $link,
        ]);
    }

    public static function newComment(string $commenterName, string $newsTitle, string $link): void
    {
        AdminNotification::create([
            'type' => 'comment',
            'title' => 'New Comment Pending Approval',
            'body' => $commenterName . ' "' . \Illuminate\Support\Str::limit($newsTitle, 40) . '" পোস্টে মন্তব্য করেছেন।',
            'link' => $link,
        ]);
    }

    /**
     * রোগীকে Appointment confirmation পাঠায় (Email + SMS), বুকিং করার সাথে সাথে।
     */
    public static function sendAppointmentConfirmationToPatient(Appointment $appointment): void
    {
        $setting = Setting::get();

        if ($setting->email_notifications_enabled && $appointment->email) {
            try {
                Mail::to($appointment->email)->send(new AppointmentConfirmedMail($appointment));
            } catch (\Exception $e) {
                Log::error('Appointment confirmation email failed: ' . $e->getMessage());
            }
        }

        if ($setting->sms_enabled && $appointment->phone) {
            $message = 'Dear ' . $appointment->name . ', your appointment request has been received for '
                . \Carbon\Carbon::parse($appointment->date)->format('d M, Y')
                . ($appointment->serial_no ? '. Serial No: ' . $appointment->serial_no : '')
                . '. - ' . config('app.name');

            SmsService::send($appointment->phone, $message);
        }
    }

    /**
     * Admin থেকে Appointment status বদলালে (Confirmed/Cancelled) রোগীকে জানায়।
     */
    public static function sendAppointmentStatusUpdateToPatient(Appointment $appointment): void
    {
        $setting = Setting::get();

        if ($setting->email_notifications_enabled && $appointment->email) {
            try {
                Mail::to($appointment->email)->send(new AppointmentStatusUpdatedMail($appointment));
            } catch (\Exception $e) {
                Log::error('Appointment status email failed: ' . $e->getMessage());
            }
        }

        if ($setting->sms_enabled && $appointment->phone) {
            $message = 'Dear ' . $appointment->name . ', your appointment on '
                . \Carbon\Carbon::parse($appointment->date)->format('d M, Y')
                . ' has been ' . $appointment->status . '. - ' . config('app.name');

            SmsService::send($appointment->phone, $message);
        }
    }

    /**
     * Online Report ready হলে রোগীকে জানায়।
     */
    public static function sendReportReadyToPatient(OnlineReport $report): void
    {
        $setting = Setting::get();

        if ($setting->email_notifications_enabled && $report->phone) {
            // OnlineReport-এ email ফিল্ড নেই, তাই phone দিয়েই skip করছি ইমেইল অংশ
            // যদি ভবিষ্যতে email ফিল্ড যোগ করা হয়, এখানে Mail::to() যোগ করা যাবে।
        }

        if ($setting->sms_enabled && $report->phone) {
            $message = 'Dear ' . $report->patient_name . ', your lab report (ID: ' . $report->report_id
                . ') is now ready. Visit our website to download. - ' . config('app.name');

            SmsService::send($report->phone, $message);
        }
    }
}
