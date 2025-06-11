<?php

namespace App\Providers;

use App\Contracts\GitHub\Actions\Factory;
use App\Contracts\GitHub\ClientFactory;
use App\Contracts\GitHub\JWTConfigurationBuilder as JWTConfigurationBuilderContract;
use App\Contracts\GitHub\JWTTokenGenerator as JWTTokenGeneratorContract;
use App\GitHub\Actions\ContainerAwareFactory;
use App\GitHub\ApiConnector;
use App\GitHub\ContainerAwareClientFactory;
use App\GitHub\JWTConfigurationBuilder;
use App\GitHub\JWTTokenGenerator;
use App\GitHub\RequestHandler;
use Github\AuthMethod;
use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\Builder;
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
     * @return list<class-string|string>
     */
    #[\Override]
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

    #[\Override]
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
        $this->app->singleton(
            Factory::class,
            static fn(Application $app) => new ContainerAwareFactory($app),
        );
    }

    private function registerApiConnector(): void
    {
        $this->app->singleton(
            ApiConnector::class,
            static fn(Application $app) => new ApiConnector($app->make(Client::class)),
        );
    }

    private function registerClient(): void
    {
        $this->app->singleton(
            Client::class,
            static function (Application $app): Client {
                try {
                    return tap(
                        $app->make(ClientFactory::class)->make($app->make(Builder::class)),
                        static function (Client $client): void {
                            $client->authenticate(config()->string('services.github.token'), authMethod: AuthMethod::ACCESS_TOKEN);
                        },
                    );
                } catch (InvalidArgumentException|\InvalidArgumentException $exception) {
                    throw new BindingResolutionException(\sprintf('Could not create the "%s" service.', Client::class), previous: $exception);
                }
            },
        );
    }

    private function registerClientFactory(): void
    {
        $this->app->singleton(
            ClientFactory::class,
            static fn(Application $app) => new ContainerAwareClientFactory($app),
        );
    }

    private function registerHttpClientBuilder(): void
    {
        $this->app->singleton(
            Builder::class,
            static fn(Application $app) => new Builder(
                $app->make(ClientInterface::class),
                $app->make(RequestFactoryInterface::class),
                $app->make(StreamFactoryInterface::class),
            ),
        );
    }

    private function registerJwtConfigurationBuilder(): void
    {
        $this->app->singleton(
            JWTConfigurationBuilderContract::class,
            static fn() => new JWTConfigurationBuilder(),
        );
    }

    private function registerJwtTokenGenerator(): void
    {
        $this->app->singleton(
            JWTTokenGeneratorContract::class,
            static fn(Application $app) => new JWTTokenGenerator(
                $app->make(JWTConfigurationBuilderContract::class),
            ),
        );
    }

    private function registerWebhookRequestHandler(): void
    {
        $this->app->singleton(
            RequestHandler::class,
            static fn(Application $app) => new RequestHandler(
                $app->make(Factory::class),
                $app->make(ClientFactory::class),
                $app->make(JWTTokenGeneratorContract::class),
            ),
        );
    }
}
