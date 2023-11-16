<?php

namespace BabDev\Providers;

use BabDev\Pagination\RoutableLengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Limit database key length
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        Livewire::setUpdateRoute(fn ($handle) => Route::post('/livewire/update', $handle)->middleware('filament.web'));
    }

    public function register(): void
    {
        $this->registerPagination();

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    private function registerPagination(): void
    {
        // Bind pagination to our local class
        $this->app->bind(LengthAwarePaginator::class, RoutableLengthAwarePaginator::class);

        // Change the current page resolver to be aware of the route parameters
        Paginator::currentPageResolver(function (string $pageName = 'page'): int {
            $route = $this->app['request']->route();

            if ($page = $route->parameter($pageName)) {
                return (int) $page;
            }

            $page = $this->app['request']->input($pageName);

            if (filter_var($page, \FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            return 1;
        });

        // Add the route resolver
        RoutableLengthAwarePaginator::currentRouteResolver(fn () => $this->app['request']->route());

        // Add the checker
        RoutableLengthAwarePaginator::paginatorChecker(fn () => !is_filament_request($this->app['request']));
    }
}
