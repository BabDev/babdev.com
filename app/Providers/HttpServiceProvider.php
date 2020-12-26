<?php

namespace BabDev\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\ResponseFactory;
use Http\Factory\Guzzle\StreamFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class HttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'guzzle',
            Guzzle::class,
            GuzzleInterface::class,
            ClientInterface::class,

            'psr.request_factory',
            RequestFactoryInterface::class,

            'psr.response_factory',
            ResponseFactoryInterface::class,

            'psr.stream_factory',
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
            'guzzle',
            static function (Application $app): GuzzleInterface {
                return new Guzzle();
            }
        );

        $this->app->alias('guzzle', Guzzle::class);
        $this->app->alias('guzzle', GuzzleInterface::class);
    }

    private function registerRequestFactory(): void
    {
        $this->app->bind(
            'psr.request_factory',
            static function (Application $app): RequestFactoryInterface {
                return new RequestFactory();
            }
        );

        $this->app->alias('psr.request_factory', RequestFactoryInterface::class);
    }

    private function registerResponseFactory(): void
    {
        $this->app->bind(
            'psr.response_factory',
            static function (Application $app): ResponseFactoryInterface {
                return new ResponseFactory();
            }
        );

        $this->app->alias('psr.response_factory', ResponseFactoryInterface::class);
    }

    private function registerStreamFactory(): void
    {
        $this->app->bind(
            'psr.stream_factory',
            static function (Application $app): StreamFactoryInterface {
                return new StreamFactory();
            }
        );

        $this->app->alias('psr.stream_factory', StreamFactoryInterface::class);
    }
}
