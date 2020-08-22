<?php

namespace BabDev\Providers;

use BabDev\Matomo\ApiConnector;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;

class MatomoServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'matomo.api',
            ApiConnector::class,
        ];
    }

    public function register(): void
    {
        $this->registerApiConnector();
    }

    private function registerApiConnector(): void
    {
        $this->app->bind(
            'matomo.api',
            static function (Application $app): ApiConnector {
                /** @var Repository $config */
                $config = $app->make('config');

                return new ApiConnector(
                    $app->make(Factory::class),
                    $config->get('services.matomo.page_id'),
                    $config->get('services.matomo.token'),
                    $config->get('services.matomo.url')
                );
            }
        );

        $this->app->alias('matomo.api', ApiConnector::class);
    }
}
