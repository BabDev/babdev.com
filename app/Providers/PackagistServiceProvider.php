<?php

namespace BabDev\Providers;

use GuzzleHttp\ClientInterface as GuzzleInterface;
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
            PackagistClient::class,
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
            PackagistClient::class,
            static fn (Application $app) => new PackagistClient(
                $app->make(GuzzleInterface::class),
                $app->make(PackagistUrlGenerator::class),
            ),
        );
    }

    private function registerUrlGenerator(): void
    {
        $this->app->bind(
            PackagistUrlGenerator::class,
            static fn () => new PackagistUrlGenerator(),
        );
    }
}
