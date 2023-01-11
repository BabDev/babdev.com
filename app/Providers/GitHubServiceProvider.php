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
use Github\AuthMethod;
use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\Builder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class GitHubServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return array<int, class-string|string>
     */
    public function provides(): array
    {
        return [
            Factory::class,
            ApiConnector::class,
            Client::class,
            ClientFactory::class,
            Builder::class,
            JWTConfigurationBuilderContract::class,
            JWTTokenGeneratorContract::class,
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
            Factory::class,
            static fn (Application $app) => new ContainerAwareFactory($app),
        );
    }

    private function registerApiConnector(): void
    {
        $this->app->bind(
            ApiConnector::class,
            static fn (Application $app) => new ApiConnector(
                $app->make(Client::class),
            ),
        );
    }

    private function registerClient(): void
    {
        $this->app->bind(
            Client::class,
            static function (Application $app): Client {
                try {
                    /** @var Repository $config */
                    $config = $app->make('config');

                    /** @var ClientFactory $factory */
                    $factory = $app->make(ClientFactory::class);

                    $client = $factory->make($app->make(Builder::class));
                    $client->authenticate($config->get('services.github.token'), null, AuthMethod::ACCESS_TOKEN);

                    return $client;
                } catch (InvalidArgumentException $exception) {
                    throw new BindingResolutionException(sprintf('Could not create the "%s" service.', Client::class), $exception->getCode(), $exception);
                }
            },
        );
    }

    private function registerClientFactory(): void
    {
        $this->app->bind(
            ClientFactory::class,
            static fn (Application $app) => new ContainerAwareClientFactory($app),
        );
    }

    private function registerHttpClientBuilder(): void
    {
        $this->app->bind(
            Builder::class,
            static fn (Application $app) => new Builder(
                $app->make(ClientInterface::class),
                $app->make(RequestFactoryInterface::class),
                $app->make(StreamFactoryInterface::class),
            ),
        );
    }

    private function registerJwtConfigurationBuilder(): void
    {
        $this->app->bind(
            JWTConfigurationBuilderContract::class,
            static fn () => new JWTConfigurationBuilder(),
        );
    }

    private function registerJwtTokenGenerator(): void
    {
        $this->app->bind(
            JWTTokenGeneratorContract::class,
            static fn (Application $app) => new JWTTokenGenerator(
                $app->make(JWTConfigurationBuilderContract::class),
            ),
        );
    }

    private function registerWebhookRequestHandler(): void
    {
        $this->app->bind(
            RequestHandler::class,
            static fn (Application $app) => new RequestHandler(
                $app->make(Factory::class),
                $app->make(ClientFactory::class),
                $app->make(JWTTokenGeneratorContract::class),
            ),
        );
    }
}
