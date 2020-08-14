<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'token' => env('GITHUB_TOKEN'),
        'apps' => [
            'pagerfanta-packages/*' => [
                'app_id' => env('GITHUB_APP_PAGERFANTA_PACKAGES_APP_ID'),
                'key' => env('GITHUB_APP_PAGERFANTA_PACKAGES_KEY'),
                'secret' => env('GITHUB_APP_PAGERFANTA_PACKAGES_SECRET'),
                'events' => [
                    'pull_request' => [
                        \BabDev\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest::class,
                    ],
                ],
            ],
        ],
    ],

];
