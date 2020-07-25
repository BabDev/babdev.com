<?php

use BabDev\Http\Middleware\VerifyCsrfToken;
use Barryvdh\Elfinder\Elfinder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Http\Middleware\Authorize;
use Laravel\Nova\Http\Middleware\BootTools;
use Laravel\Nova\Http\Middleware\DispatchServingNovaEvent;

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */
    'dir' => [],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix' => 'elfinder',
        'middleware' => [
            'web',
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            Authenticate::class,
            DispatchServingNovaEvent::class,
            BootTools::class,
            Authorize::class,
        ],
        'domain' => env('NOVA_DOMAIN_NAME', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => [Elfinder::class, 'checkAccess'],

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => [
        [
            'driver' => 'LocalFileSystem',
            'path' => public_path('attachments'),
            'URL' => '/attachments',
            'accessControl' => config('elfinder.access'),
            'alias' => 'Post Attachments',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => [],

    /*
    |--------------------------------------------------------------------------
    | Root Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with every root by default.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1#root-options
    |
    */
    'root_options' => [],

];
