<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * সাধারণ SMS গেটওয়ে পাঠানোর মেথড — বাংলাদেশের বেশিরভাগ SMS API
     * (BulkSMSBD, Alpha SMS, Mimsms ইত্যাদি) একই ধরনের GET/POST query parameter নেয়।
     * এটা সেই generic প্যাটার্ন অনুসরণ করে।
     */
    public static function send(string $phone, string $message): bool
    {
        $setting = Setting::get();

        if (! $setting->sms_enabled || ! $setting->sms_api_url || ! $setting->sms_api_key) {
            return false;
        }

        // বাংলাদেশি নম্বর ফরম্যাট ঠিক করা (880 কোড ছাড়া হলে যোগ করা)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '88' . $cleanPhone;
        } elseif (! str_starts_with($cleanPhone, '880')) {
            $cleanPhone = '880' . $cleanPhone;
        }

        try {
            $response = Http::timeout(10)->get($setting->sms_api_url, [
                'api_key' => $setting->sms_api_key,
                'senderid' => $setting->sms_sender_id,
                'number' => $cleanPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('SMS send failed', ['response' => $response->body(), 'phone' => $cleanPhone]);

            return false;
        } catch (\Exception $e) {
            Log::error('SMS send exception: ' . $e->getMessage());

            return false;
        }
    }
}
