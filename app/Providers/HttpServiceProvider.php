<?php

namespace App\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

final class HttpServiceProvider extends ServiceProvider implements DeferrableProvider
{
    private const string USER_AGENT = 'BabDev/1.0';

    /**
     * @return list<class-string|string>
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

    public function boot(): void
    {
        Http::globalRequestMiddleware(
            static fn(RequestInterface $request): RequestInterface => $request->withHeader('User-Agent', self::USER_AGENT),
        );
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
            static fn(): GuzzleInterface => new Guzzle([
                'handler' => make_guzzle_handler(),
                'headers' => ['User-Agent' => self::USER_AGENT],
            ]),
        );

        $this->app->alias(GuzzleInterface::class, Guzzle::class);
        $this->app->alias(GuzzleInterface::class, ClientInterface::class);
    }

    private function registerPsr17Services(): void
    {
        $this->app->singleton(HttpFactory::class);

        foreach ([RequestFactoryInterface::class, ResponseFactoryInterface::class, ServerRequestFactoryInterface::class, StreamFactoryInterface::class, UploadedFileFactoryInterface::class, UriFactoryInterface::class] as $psr17Interface) {
            $this->app->alias(HttpFactory::class, $psr17Interface);
        }
    }
}
