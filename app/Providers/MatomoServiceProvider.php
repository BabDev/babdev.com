<?php

namespace BabDev\Providers;

use BabDev\Matomo\ApiConnector;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;

final class MatomoServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [
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
            ApiConnector::class,
            static function (Application $app): ApiConnector {
                /** @var Repository $config */
                $config = $app->make('config');

                return new ApiConnector(
                    $app->make(Factory::class),
                    $config->get('services.matomo.page_id'),
                    $config->get('services.matomo.token'),
                    $config->get('services.matomo.url'),
                );
            }
        );
    }
}
