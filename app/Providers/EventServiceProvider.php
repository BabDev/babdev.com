<?php

namespace BabDev\Providers;

use BabDev\Breadcrumbs\Events\AfterBreadcrumbGenerated;
use BabDev\Listeners\AppendPageNumberToBreadcrumbs;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
    ];
}
