<?php

namespace BabDev\Providers;

use BabDev\Contracts\GitHub\Actions\Factory;
use BabDev\Contracts\GitHub\ClientFactory;
use BabDev\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use BabDev\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use BabDev\GitHub\Actions\ContainerAwareFactory;
use BabDev\GitHub\ApiConnector;
use BabDev\GitHub\ContainerAwareClientFactory;
use BabDev\GitHub\JWTConfigurationBuilder;
use BabDev\GitHub\JWTTokenGenerator;
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
            'github.action_factory',
            Factory::class,

            'github.api',
            ApiConnector::class,

            'github.client',
            Client::class,

            'github.client_factory',
            ClientFactory::class,

            'github.http_client.builder',
            Builder::class,

            'github.jwt.configuration_builder',
            JWTConfigurationBuilderContract::class,

            'github.jwt.token_generator',
            JWTTokenGeneratorContract::class,

            'github.webhook.request_handler',
            RequestHandler::class,
        ];
    }

    public function register(): void
    {
        $this->registerActionFactory();
        $this->registerApiConnector();
        $this->registerClient();
        $this->registerClientFactory();
        $this->registerHttpClientBuilder();
        $this->registerJwtConfigurationBuilder();
        $this->registerJwtTokenGenerator();
        $this->registerWebhookRequestHandler();
    }

    private function registerActionFactory(): void
    {
        $this->app->bind(
            'github.action_factory',
            static function (Application $app): Factory {
                return new ContainerAwareFactory($app);
            }
        );

        $this->app->alias('github.action_factory', Factory::class);
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

                    /** @var ClientFactory $factory */
                    $factory = $app->make('github.client_factory');

                    $client = $factory->make($app->make('github.http_client.builder'));
                    $client->authenticate($config->get('services.github.token'), null, Client::AUTH_ACCESS_TOKEN);

                    return $client;
                } catch (InvalidArgumentException $exception) {
                    throw new BindingResolutionException('Could not create the "github.client" service.', $exception->getCode(), $exception);
                }
            }
        );

        $this->app->alias('github.client', Client::class);
    }

    private function registerClientFactory(): void
    {
        $this->app->bind(
            'github.client_factory',
            static function (Application $app): ClientFactory {
                return new ContainerAwareClientFactory($app);
            }
        );

        $this->app->alias('github.client_factory', ClientFactory::class);
    }

    private function registerHttpClientBuilder(): void
    {
        $this->app->bind(
            'github.http_client.builder',
            static function (Application $app): Builder {
                return new Builder(
                    $app->make('guzzle'),
                    $app->make('psr.request_factory'),
                    $app->make('psr.stream_factory')
                );
            }
        );

        $this->app->alias('github.http_client.builder', Builder::class);
    }

    private function registerJwtConfigurationBuilder(): void
    {
        $this->app->bind(
            'github.jwt.token_generator',
            static function (): JWTConfigurationBuilderContract {
                return new JWTConfigurationBuilder();
            }
        );

        $this->app->alias('github.jwt.configuration_builder', JWTConfigurationBuilderContract::class);
    }

    private function registerJwtTokenGenerator(): void
    {
        $this->app->bind(
            'github.jwt.token_generator',
            static function (Application $app): JWTTokenGeneratorContract {
                return new JWTTokenGenerator(
                    $app->make('github.jwt.configuration_builder')
                );
            }
        );

        $this->app->alias('github.jwt.token_generator', JWTTokenGeneratorContract::class);
    }

    private function registerWebhookRequestHandler(): void
    {
        $this->app->bind(
            'github.webhook.request_handler',
            static function (Application $app): RequestHandler {
                return new RequestHandler(
                    $app->make('github.action_factory'),
                    $app->make('github.client_factory'),
                    $app->make('github.jwt.token_generator')
                );
            }
        );

        $this->app->alias('github.webhook.request_handler', RequestHandler::class);
    }
}
