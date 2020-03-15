<?php

namespace BabDev\Providers;

use Github\Client;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\Builder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'github.client',
            static function (Application $app): Client {
                try {
                    /** @var Repository $config */
                    $config = $app->make('config');

                    $client = new Client($app->make('github.http_client.builder'));
                    $client->authenticate($config->get('services.github.token'), null, Client::AUTH_HTTP_TOKEN);

                    return $client;
                } catch (InvalidArgumentException $exception) {
                    throw new BindingResolutionException('Could not create the "github.client" service.', $exception->getCode(), $exception);
                }
            }
        );

        $this->app->alias('github.client', Client::class);

        $this->app->singleton(
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
}
