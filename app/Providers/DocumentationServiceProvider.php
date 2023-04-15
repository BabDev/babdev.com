<?php

namespace BabDev\Providers;

use BabDev\Contracts\Services\DocumentationProcessor as DocumentationProcessorContract;
use BabDev\GitHub\ApiConnector;
use BabDev\Services\DocumentationProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class DocumentationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return array<int, class-string|string>
     */
    public function provides(): array
    {
        return [
            DocumentationProcessorContract::class,
        ];
    }

    public function register(): void
    {
        $this->app->singleton(
            DocumentationProcessorContract::class,
            static fn (Application $app) => new DocumentationProcessor(
                $app->make(ApiConnector::class),
                $app->make('cache.store'),
            ),
        );
    }
}
