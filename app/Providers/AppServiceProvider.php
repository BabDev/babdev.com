<?php

namespace BabDev\Providers;

use BabDev\GitHub\ApiConnector;
use BabDev\Pagination\RoutableLengthAwarePaginator;
use BabDev\Services\DocumentationProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Limit database key length
        Schema::defaultStringLength(191);
    }

    public function register(): void
    {
        $this->registerPagination();

        $this->app->bind(
            DocumentationProcessor::class,
            static function (Application $app): DocumentationProcessor {
                return new DocumentationProcessor(
                    $app->make('github.api'),
                    $app->make('cache.store'),
                    new \ParsedownExtra()
                );
            }
        );

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    private function registerPagination(): void
    {
        // Bind pagination to our local class
        $this->app->bind(LengthAwarePaginator::class, RoutableLengthAwarePaginator::class);

        // Change the current page resolver to be aware of the route parameters
        Paginator::currentPageResolver(function ($pageName = 'page') {
            $route = $this->app['request']->route();

            if ($page = $route->parameter($pageName)) {
                return $page;
            }

            $page = $this->app['request']->input($pageName);

            if (\filter_var($page, \FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            return 1;
        });

        // Add the route resolver
        RoutableLengthAwarePaginator::currentRouteResolver(function () {
            return $this->app['request']->route();
        });
    }
}
