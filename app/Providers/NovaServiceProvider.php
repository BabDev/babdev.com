<?php

namespace BabDev\Providers;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes();
    }

    protected function cards(): array
    {
        return [
            new Help(),
        ];
    }
}
