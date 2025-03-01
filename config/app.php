<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'domain' => env('APP_DOMAIN_NAME'),

    'filament_domain' => env('FILAMENT_DOMAIN'),

    'timezone' => 'UTC',

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        BabDev\Providers\AppServiceProvider::class,
        BabDev\Providers\DocumentationServiceProvider::class,
        BabDev\Providers\EventServiceProvider::class,
        BabDev\Providers\GitHubServiceProvider::class,
        BabDev\Providers\HttpServiceProvider::class,
        BabDev\Providers\PackagistServiceProvider::class,
        BabDev\Providers\RouteServiceProvider::class,
        BabDev\Providers\Filament\AppPanelProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // ...
    ])->toArray(),

];
