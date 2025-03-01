<?php

return [

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => env('APP_PUBLIC_PATH', storage_path('app/public')),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
    ],

    'links' => [
        public_path('storage') => env('APP_PUBLIC_PATH', storage_path('app/public')),
    ],

];
