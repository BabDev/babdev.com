<?php

namespace BabDev\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(static function (): void {
            Route::middleware('web')
                ->domain(config('app.domain'))
                ->group(base_path('routes/web.php'));

            Route::middleware('github.app')
                ->domain(config('app.domain'))
                ->group(base_path('routes/github.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', static fn (Request $request) => Limit::perMinute(60));

        RateLimiter::for('github.app', static fn (Request $request) => Limit::perMinute(60));
    }
}
