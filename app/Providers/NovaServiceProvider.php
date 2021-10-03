<?php

namespace BabDev\Providers;

use BabDev\Models\User;
use BabDev\Nova\Dashboards\MatomoAnalytics;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Nova\Card;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboard;
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
                ],
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

    /**
     * @return Card[]
     */
    protected function cards(): array
    {
        return [
            new Help(),
        ];
    }

    /**
     * @return Dashboard[]
     */
    protected function dashboards(): array
    {
        return [
            new MatomoAnalytics(),
        ];
    }
}
