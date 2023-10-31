<?php

return [
    'system' => [
        'api_request_limit_rate' => '60,1',
        'delete_deprecated_payment_after_hours' => 24,
        'delete_deprecated_payment_count' => 20,
    ],
    'global' => [
        'pagination' => 10,
        'navasan_api_key' => env('NAVASAN_API_KEY'),
        'navasan_base_url' => 'https://api.navasan.tech/latest/',
    ],
];
