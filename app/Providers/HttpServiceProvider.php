<?php

namespace BabDev\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Http\Adapter\Guzzle7\Client;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Message\RequestFactory;
use Http\Message\ResponseFactory;
use Http\Message\StreamFactory;
use Http\Message\StreamFactory\GuzzleStreamFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;

class HttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            'guzzle',
            Guzzle::class,
            GuzzleInterface::class,

            'httplug',
            HttpClient::class,
            HttpAsyncClient::class,
            ClientInterface::class,

            'httplug.message_factory',
            MessageFactory::class,
            RequestFactory::class,
            ResponseFactory::class,

            'httplug.stream_factory',
            StreamFactory::class,
        ];
    }

    public function register(): void
    {
        $this->registerGuzzle();
        $this->registerHttplug();
        $this->registerMessageFactory();
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

    private function registerHttplug(): void
    {
        $this->app->bind(
            'httplug',
            static function (Application $app): ClientInterface {
                return new Client();
            }
        );

        $this->app->alias('httplug', HttpClient::class);
        $this->app->alias('httplug', HttpAsyncClient::class);
        $this->app->alias('httplug', ClientInterface::class);
    }

    private function registerMessageFactory(): void
    {
        $this->app->bind(
            'httplug.message_factory',
            static function (Application $app): MessageFactory {
                return new GuzzleMessageFactory();
            }
        );

        $this->app->alias('httplug.message_factory', MessageFactory::class);
        $this->app->alias('httplug.message_factory', RequestFactory::class);
        $this->app->alias('httplug.message_factory', ResponseFactory::class);
    }

    private function registerStreamFactory(): void
    {
        $this->app->bind(
            'httplug.stream_factory',
            static function (Application $app): StreamFactory {
                return new GuzzleStreamFactory();
            }
        );

        $this->app->alias('httplug.stream_factory', StreamFactory::class);
    }
}
