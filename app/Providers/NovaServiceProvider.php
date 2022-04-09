<?php

namespace BabDev\Providers;

use BabDev\Models\User;
use BabDev\Nova\Dashboards\Main;
use BabDev\Nova\Dashboards\MatomoAnalytics;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

final class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes();
    }

    protected function gate(): void
    {
        Gate::define(
            'viewNova',
            static fn (User $user) => \in_array(
                $user->email,
                [
                    'michael.babker@gmail.com',
                ],
                true,
            ),
        );
    }

    /**
     * @return Dashboard[]
     */
    protected function dashboards(): array
    {
        return [
            new Main(),
            new MatomoAnalytics(),
        ];
    }
}
