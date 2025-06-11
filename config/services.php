<?php

return [

    'github' => [
        'token' => env('GITHUB_TOKEN'),
        'apps' => [
            'Pagerfanta/*' => [
                'app_id' => env('GITHUB_APP_PAGERFANTA_PACKAGES_APP_ID'),
                'key' => env('GITHUB_APP_PAGERFANTA_PACKAGES_KEY'),
                'secret' => env('GITHUB_APP_PAGERFANTA_PACKAGES_SECRET'),
                'events' => [
                    'pull_request' => [
                        \App\GitHub\Actions\ClosePagerfantaReadOnlyRepoPullRequest::class,
                    ],
                ],
            ],
        ],
    ],

];
