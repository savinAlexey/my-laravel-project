<?php

return [
    'domains' => [
        'api' => env('SWEGO_API_DOMAIN', 'szwego.com'),
        'web' => env('SWEGO_WEB_DOMAIN', 'www.szwego.com'),
    ],
    'timeout' => env('SWEGO_TIMEOUT', 30),
    'retry_attempts' => env('SWEGO_RETRY_ATTEMPTS', 3),
];
