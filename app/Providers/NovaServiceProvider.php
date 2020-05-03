<?php

namespace BabDev\Providers;

use BabDev\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes(
                [
                    'web',
                    StartSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                ]
            );
    }

    protected function cards(): array
    {
        return [
            new Help(),
        ];
    }
}
