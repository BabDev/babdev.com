<?php

namespace BabDev\Providers;

use BabDev\Http\Middleware\VerifyCsrfToken;
use BabDev\Models\User;
use BabDev\Nova\Dashboards\MatomoAnalytics;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

final class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes(): void
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

    protected function gate(): void
    {
        /** @var Gate $gate */
        $gate = $this->app->make(Gate::class);

        $gate->define(
            'viewNova',
            static fn (User $user) => \in_array(
                $user->email,
                [
                    'michael.babker@gmail.com',
                ],
            ),
        );
    }

    protected function cards(): array
    {
        return [
            new Help(),
        ];
    }

    protected function dashboards(): array
    {
        return [
            new MatomoAnalytics(),
        ];
    }
}
