<?php

namespace BabDev\Providers;

use Http\Adapter\Guzzle6\Client;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Message\RequestFactory;
use Http\Message\ResponseFactory;
use Http\Message\StreamFactory;
use Http\Message\StreamFactory\GuzzleStreamFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'httplug',
            static function (Application $app): Client {
                return new Client();
            }
        );

        $this->app->alias('httplug', HttpClient::class);
        $this->app->alias('httplug', HttpAsyncClient::class);
        $this->app->alias('httplug', ClientInterface::class);

        $this->app->singleton(
            'httplug.message_factory',
            static function (Application $app): GuzzleMessageFactory {
                return new GuzzleMessageFactory();
            }
        );

        $this->app->alias('httplug.message_factory', MessageFactory::class);
        $this->app->alias('httplug.message_factory', RequestFactory::class);
        $this->app->alias('httplug.message_factory', ResponseFactory::class);

        $this->app->singleton(
            'httplug.stream_factory',
            static function (Application $app): GuzzleStreamFactory {
                return new GuzzleStreamFactory();
            }
        );

        $this->app->alias('httplug.stream_factory', StreamFactory::class);
    }
}
