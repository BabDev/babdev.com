<?php

namespace BabDev\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Spatie\Packagist\Packagist;

class PackagistServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [
            'packagist.api',
            Packagist::class,
        ];
    }

    public function register()
    {
        $this->app->bind(
            'packagist.api',
            static function (Application $app): Packagist {
                return new Packagist($app->make('guzzle'));
            }
        );

        $this->app->alias('packagist.api', Packagist::class);
    }
}
