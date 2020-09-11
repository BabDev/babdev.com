<?php

namespace BabDev\Providers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function (Router $router): void {
            $router->middleware('web')
                ->domain($this->app['config']->get('app.domain', null))
                ->group($this->app->basePath('routes/web.php'));

            $router->middleware('github.app')
                ->domain($this->app['config']->get('app.domain', null))
                ->group($this->app->basePath('routes/github.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        /** @var RateLimiter $rateLimiter */
        $rateLimiter = $this->app->make(RateLimiter::class);

        $rateLimiter->for('api', function (Request $request) {
            return Limit::perMinute(60);
        });

        $rateLimiter->for('github.app', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
