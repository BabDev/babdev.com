<?php

namespace BabDev\Providers;

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
            DocumentationProcessor::class,
        ];
    }

    public function register(): void
    {
        $this->app->bind(
            'documentation',
            static function (Application $app): DocumentationProcessor {
                return new DocumentationProcessor(
                    $app->make('github.api'),
                    $app->make('cache.store'),
                    new \ParsedownExtra()
                );
            }
        );

        $this->app->alias('documentation', DocumentationProcessor::class);
    }
}
