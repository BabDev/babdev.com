<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\ContainerAwareClientFactory;
use Github\Client;
use Tests\TestCase;

final class ContainerAwareClientFactoryTest extends TestCase
{
    public function test_the_factory_creates_an_api_client(): void
    {
        $factory = $this->app->make(ContainerAwareClientFactory::class);

        $client = $factory->make(null, 'machine-man-preview');

        $this->assertInstanceOf(Client::class, $client);
        $this->assertSame('machine-man-preview', $client->getApiVersion());
    }
}
