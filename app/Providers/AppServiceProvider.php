<?php

namespace BabDev\Providers;

use BabDev\Pagination\RoutableLengthAwarePaginator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Route as RouteObject;
use Illuminate\Support\Facades\RateLimiter;
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

        RateLimiter::for('api', static fn(Request $request) => Limit::perMinute(60));
        RateLimiter::for('github.app', static fn(Request $request) => Limit::perMinute(60));

        Livewire::setUpdateRoute(static fn($handle) => Route::post('/livewire/update', $handle)->middleware('filament.web'));
    }

    #[\Override]
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
        Paginator::currentPageResolver(static function (string $pageName = 'page'): int {
            $request = request();

            $route = $request->route();

            if ($page = ($route instanceof RouteObject ? $route->parameter($pageName) : null)) {
                return (int) $page;
            }

            $page = $request->input($pageName);

            if (is_numeric($page) && filter_var($page, \FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            return 1;
        });

        // Add the route resolver
        RoutableLengthAwarePaginator::currentRouteResolver(static fn() => request()->route());

        // Add the checker
        RoutableLengthAwarePaginator::paginatorChecker(static fn() => !is_filament_request(request()));
    }
}
