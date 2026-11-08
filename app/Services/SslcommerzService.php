<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslcommerzService
{
    /**
     * SSLCommerz-এ পেমেন্ট সেশন শুরু করে এবং gateway URL রিটার্ন করে,
     * যেখানে ইউজারকে রিডাইরেক্ট করতে হবে।
     */
    public static function initiate(array $data): ?string
    {
        $payload = array_merge([
            'store_id' => config('sslcommerz.store_id'),
            'store_passwd' => config('sslcommerz.store_password'),
            'currency' => 'BDT',
            'shipping_method' => 'NO',
            'product_category' => 'Healthcare',
            'product_profile' => 'general',
            'cus_add1' => 'N/A',
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'ship_name' => 'N/A',
            'ship_add1' => 'N/A',
            'ship_city' => 'N/A',
            'ship_postcode' => '1000',
            'ship_country' => 'N/A',
        ], $data);

        try {
            $response = Http::asForm()->post(config('sslcommerz.api_url'), $payload);
            $result = $response->json();

            if (($result['status'] ?? null) === 'SUCCESS') {
                return $result['GatewayPageURL'];
            }

            Log::warning('SSLCommerz init failed', ['response' => $result]);

            return null;
        } catch (\Exception $e) {
            Log::error('SSLCommerz init exception: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * success_url-এ ফিরে আসা পেমেন্টকে SSLCommerz সার্ভারের সাথে validate করে,
     * যাতে কেউ fake success_url hit করে পেমেন্ট ছাড়াই "paid" মার্ক করতে না পারে।
     */
    public static function validateTransaction(string $valId): bool
    {
        try {
            $response = Http::get(config('sslcommerz.validation_url'), [
                'val_id' => $valId,
                'store_id' => config('sslcommerz.store_id'),
                'store_passwd' => config('sslcommerz.store_password'),
                'format' => 'json',
            ]);

            $result = $response->json();

            return in_array($result['status'] ?? null, ['VALID', 'VALIDATED']);
        } catch (\Exception $e) {
            Log::error('SSLCommerz validation exception: ' . $e->getMessage());

            return false;
        }
    }
}
