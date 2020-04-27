<?php

namespace BabDev\Providers;

use BabDev\Breadcrumbs\Events\AfterBreadcrumbGenerated;
use BabDev\Listeners\AddDefaultMediaCustomProperties;
use BabDev\Listeners\AppendPageNumberToBreadcrumbs;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*
         * BabDev events - Breadcrumbs package
         */

        AfterBreadcrumbGenerated::class => [
            AppendPageNumberToBreadcrumbs::class,
        ],

        /*
         * Spatie events - Media Library package
         */

        MediaHasBeenAdded::class => [
            AddDefaultMediaCustomProperties::class,
        ],
    ];
}
