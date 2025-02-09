<?php

namespace BabDev\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

final class HttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return array<int, class-string|string>
     */
    #[\Override]
    public function provides(): array
    {
        return [
            Guzzle::class,
            GuzzleInterface::class,
            ClientInterface::class,
            HttpFactory::class,
            RequestFactoryInterface::class,
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
            UriFactoryInterface::class,
        ];
    }

    #[\Override]
    public function register(): void
    {
        $this->registerGuzzle();
        $this->registerPsr17Services();
    }

    private function registerGuzzle(): void
    {
        $this->app->bind(
            GuzzleInterface::class,
            static fn() => new Guzzle(['headers' => ['User-Agent' => 'BabDev/1.0']]),
        );

        $this->app->alias(GuzzleInterface::class, Guzzle::class);
        $this->app->alias(GuzzleInterface::class, ClientInterface::class);
    }

    private function registerPsr17Services(): void
    {
        $this->app->singleton(
            HttpFactory::class,
            static fn() => new HttpFactory(),
        );

        foreach ([RequestFactoryInterface::class, ResponseFactoryInterface::class, ServerRequestFactoryInterface::class, StreamFactoryInterface::class, UploadedFileFactoryInterface::class, UriFactoryInterface::class] as $psr17Interface) {
            $this->app->alias(HttpFactory::class, $psr17Interface);
        }
    }
}
