<?php

namespace BabDev\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Spatie\Packagist\Packagist;

class PackagistServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'packagist.api',
            static function (Application $app): Packagist {
                return new Packagist($app->make('guzzle'));
            }
        );

        $this->app->alias('packagist.api', Packagist::class);
    }
}
