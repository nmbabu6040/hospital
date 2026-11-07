<?php

namespace App\Services;

use App\Models\AdminNotification;

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
}
