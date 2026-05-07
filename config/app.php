<?php

return [
    'name' => env('APP_NAME', 'SupportDesk Lite'),
    'env' => env('APP_ENV', 'local'),
    'debug' => (bool) env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Europe/Amsterdam',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'nl_NL',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
];
