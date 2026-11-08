<?php

return [
    'store_id' => env('SSLCZ_STORE_ID'),
    'store_password' => env('SSLCZ_STORE_PASSWORD'),
    'testmode' => env('SSLCZ_TESTMODE', true),

    'api_url' => env('SSLCZ_TESTMODE', true)
        ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
        : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php',

    'validation_url' => env('SSLCZ_TESTMODE', true)
        ? 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php'
        : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php',
];
