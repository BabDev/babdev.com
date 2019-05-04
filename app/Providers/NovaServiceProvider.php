<?php

namespace BabDev\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->register();
    }

    protected function gate(): void
    {
        Gate::define(
            'viewNova',
            function ($user) {
                return \in_array(
                    $user->email,
                    [
                        //
                    ]
                );
            }
        );
    }

    protected function cards(): array
    {
        return [
            new Help(),
        ];
    }

    public function tools(): array
    {
        return [];
    }
}
