<?php

namespace BabDev\Providers;

use BabDev\Listeners\AddDefaultMediaCustomProperties;
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
         * Spatie events - Media Library package
         */

        MediaHasBeenAdded::class => [
            AddDefaultMediaCustomProperties::class
        ],
    ];
}
