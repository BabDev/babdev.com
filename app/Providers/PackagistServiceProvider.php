<?php

namespace BabDev\Providers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Spatie\Packagist\PackagistClient;
use Spatie\Packagist\PackagistUrlGenerator;

final class PackagistServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return array<int, class-string|string>
     */
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
        $this->app->singleton(
            PackagistClient::class,
            static fn (Application $app) => new PackagistClient(
                $app->make(Guzzle::class),
                $app->make(PackagistUrlGenerator::class),
            ),
        );
    }

    private function registerUrlGenerator(): void
    {
        $this->app->singleton(
            PackagistUrlGenerator::class,
            static fn () => new PackagistUrlGenerator(),
        );
    }
}
