<?php

namespace BabDev\Providers;

use BabDev\Pagination\RoutableLengthAwarePaginator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as TelescopePackageServiceProvider;
use Livewire\Livewire;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Limit database key length
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        RateLimiter::for('github.app', static fn(Request $request) => Limit::perMinute(60));

        Livewire::setUpdateRoute(static fn(array|callable|null|string $handle) => Route::post('/livewire/update', $handle)->middleware('filament.web'));
    }

    #[\Override]
    public function register(): void
    {
        $this->registerPagination();

        if ($this->app->isLocal()) {
            $this->app->register(TelescopePackageServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    private function registerPagination(): void
    {
        // Bind pagination to our local class
        $this->app->bind(LengthAwarePaginator::class, RoutableLengthAwarePaginator::class);

        // Decorate the current page resolver to be aware of the route parameters
        /** @var (\Closure(string): int)|null $defaultPageResolver */
        $defaultPageResolver = new \ReflectionClass(Paginator::class)
            ->getProperty('currentPageResolver')
            ->getValue();

        Paginator::currentPageResolver(static function (string $pageName = 'page') use ($defaultPageResolver): int {
            $page = request()->route($pageName);

            if (is_numeric($page) && filter_var($page, \FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            if ($defaultPageResolver !== null) {
                return $defaultPageResolver($pageName);
            }

            return 1;
        });

        // Add the route resolver
        RoutableLengthAwarePaginator::currentRouteResolver(static fn() => request()->route());

        // Add the checker
        RoutableLengthAwarePaginator::paginatorChecker(static fn() => !is_filament_request(request()));
    }
}
