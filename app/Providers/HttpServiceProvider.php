<?php

namespace BabDev\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\ResponseFactory;
use Http\Factory\Guzzle\StreamFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class HttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return array<int, class-string|string>
     */
    public function provides(): array
    {
        return [
            Guzzle::class,
            GuzzleInterface::class,
            ClientInterface::class,
            RequestFactoryInterface::class,
            ResponseFactoryInterface::class,
            StreamFactoryInterface::class,
        ];
    }

    public function register(): void
    {
        $this->registerGuzzle();
        $this->registerRequestFactory();
        $this->registerResponseFactory();
        $this->registerStreamFactory();
    }

    private function registerGuzzle(): void
    {
        $this->app->bind(
            GuzzleInterface::class,
            static fn () => new Guzzle(['headers' => ['User-Agent' => 'BabDev/1.0']]),
        );

        $this->app->alias(GuzzleInterface::class, Guzzle::class);
        $this->app->alias(GuzzleInterface::class, ClientInterface::class);
    }

    private function registerRequestFactory(): void
    {
        $this->app->singleton(
            RequestFactoryInterface::class,
            static fn () => new RequestFactory(),
        );
    }

    private function registerResponseFactory(): void
    {
        $this->app->singleton(
            ResponseFactoryInterface::class,
            static fn () => new ResponseFactory(),
        );
    }

    private function registerStreamFactory(): void
    {
        $this->app->singleton(
            StreamFactoryInterface::class,
            static fn () => new StreamFactory(),
        );
    }
}
