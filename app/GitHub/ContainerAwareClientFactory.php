<?php

namespace BabDev\GitHub;

use BabDev\Contracts\GitHub\ClientFactory;
use Github\Client;
use Github\HttpClient\Builder;
use Illuminate\Contracts\Container\Container;

final class ContainerAwareClientFactory implements ClientFactory
{
    public function __construct(private Container $container)
    {
    }

    public function make(?Builder $httpClientBuilder = null, ?string $apiVersion = null, ?string $enterpriseUrl = null): Client
    {
        $builder = $httpClientBuilder ?: $this->container->make(Builder::class);

        return new Client($builder, $apiVersion, $enterpriseUrl);
    }
}
