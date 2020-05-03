<?php

namespace BabDev\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    private function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->domain($this->app['config']->get('app.domain', null))
            ->group($this->app->basePath('routes/web.php'));
    }
}
