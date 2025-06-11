<?php

namespace App\Providers;

use App\Contracts\Services\DocumentationProcessor as DocumentationProcessorContract;
use App\GitHub\ApiConnector;
use App\Services\DocumentationProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class DocumentationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return list<class-string|string>
     */
    #[\Override]
    public function provides(): array
    {
        return [
            DocumentationProcessorContract::class,
        ];
    }

    #[\Override]
    public function register(): void
    {
        $this->app->singleton(
            DocumentationProcessorContract::class,
            static fn(Application $app) => new DocumentationProcessor(
                $app->make(ApiConnector::class),
                $app->make('cache.store'),
            ),
        );
    }
}
