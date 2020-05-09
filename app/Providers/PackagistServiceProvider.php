<?php

namespace BabDev\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Spatie\Packagist\PackagistClient;
use Spatie\Packagist\PackagistUrlGenerator;

class PackagistServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'packagist.api',
            PackagistClient::class,

            'packagist.url_generator',
            PackagistUrlGenerator::class,
        ];
    }

    public function register(): void
    {
        $this->registerApiConnector();
        $this->registerUrlGenerator();
    }

    private function registerApiConnector(): void
    {
        $this->app->bind(
            'packagist.api',
            static function (Application $app): PackagistClient {
                return new PackagistClient(
                    $app->make('guzzle'),
                    $app->make('packagist.url_generator')
                );
            }
        );

        $this->app->alias('packagist.api', PackagistClient::class);
    }

    private function registerUrlGenerator(): void
    {
        $this->app->bind(
            'packagist.url_generator',
            static function (Application $app): PackagistUrlGenerator {
                return new PackagistUrlGenerator();
            }
        );

        $this->app->alias('packagist.url_generator', PackagistUrlGenerator::class);
    }
}
