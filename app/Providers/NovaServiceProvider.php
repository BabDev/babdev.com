<?php

namespace BabDev\Providers;

use BabDev\Http\Middleware\VerifyCsrfToken;
use BabDev\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Llaski\NovaScheduledJobs\NovaScheduledJobsTool;

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

    protected function gate()
    {
        /** @var Gate $gate */
        $gate = $this->app->make(Gate::class);

        $gate->define(
            'viewNova',
            static function (User $user): bool {
                return \in_array(
                    $user->email,
                    [
                        'michael.babker@gmail.com',
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
        return [
            new NovaScheduledJobsTool(),
        ];
    }
}
