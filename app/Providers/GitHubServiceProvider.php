<?php

namespace BabDev\Providers;

use BabDev\GitHub\ApiConnector;
use BabDev\GitHub\RequestHandler;
use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\Builder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'github.api',
            ApiConnector::class,

            'github.client',
            Client::class,

            'github.http_client.builder',
            Builder::class,

            'github.webhook.request_handler',
            RequestHandler::class,
        ];
    }

    public function register(): void
    {
        $this->registerApiConnector();
        $this->registerClient();
        $this->registerHttpClientBuilder();
        $this->registerWebhookRequestHandler();
    }

    private function registerApiConnector(): void
    {
        $this->app->bind(
            'github.api',
            static function (Application $app): ApiConnector {
                return new ApiConnector($app->make('github.client'));
            }
        );

        $this->app->alias('github.api', ApiConnector::class);
    }

    private function registerClient(): void
    {
        $this->app->bind(
            'github.client',
            static function (Application $app): Client {
                try {
                    /** @var Repository $config */
                    $config = $app->make('config');

                    $client = new Client($app->make('github.http_client.builder'));
                    $client->authenticate($config->get('services.github.token'), null, Client::AUTH_ACCESS_TOKEN);

                    return $client;
                } catch (InvalidArgumentException $exception) {
                    throw new BindingResolutionException('Could not create the "github.client" service.', $exception->getCode(), $exception);
                }
            }
        );

        $this->app->alias('github.client', Client::class);
    }

    private function registerHttpClientBuilder(): void
    {
        $this->app->bind(
            'github.http_client.builder',
            static function (Application $app): Builder {
                return new Builder(
                    $app->make('httplug'),
                    $app->make('httplug.message_factory'),
                    $app->make('httplug.stream_factory')
                );
            }
        );

        $this->app->alias('github.http_client.builder', Builder::class);
    }

    private function registerWebhookRequestHandler(): void
    {
        $this->app->bind(
            'github.webhook.request_handler',
            static function (Application $app): RequestHandler {
                return new RequestHandler(
                    $app->make('events'),
                    $app->make('github.http_client.builder')
                );
            }
        );

        $this->app->alias('github.webhook.request_handler', RequestHandler::class);
    }
}
