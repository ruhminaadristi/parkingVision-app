<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Database
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk koneksi ke Firebase Realtime Database
    |
    */
    'database' => [
        'url' => env('FIREBASE_DATABASE_URL', 'https://tugasakhir-2a01a-default-rtdb.asia-southeast1.firebasedatabase.app'),
        'ssl_verify' => env('FIREBASE_SSL_VERIFY', false),
    ],
];
