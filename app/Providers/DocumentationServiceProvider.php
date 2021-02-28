<?php

namespace BabDev\Providers;

use BabDev\Contracts\Services\DocumentationProcessor as DocumentationProcessorContract;
use BabDev\Services\DocumentationProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DocumentationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'documentation',
            DocumentationProcessorContract::class,
        ];
    }

    public function register(): void
    {
        $this->app->bind(
            'documentation',
            static fn (Application $app) => new DocumentationProcessor(
                $app->make('github.api'),
                $app->make('cache.store'),
            ),
        );

        $this->app->alias('documentation', DocumentationProcessorContract::class);
    }
}
