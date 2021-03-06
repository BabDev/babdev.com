<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\ContainerAwareClientFactory;
use Github\Client;
use Tests\TestCase;

class ContainerAwareClientFactoryTest extends TestCase
{
    /** @test */
    public function the_factory_creates_an_api_client(): void
    {
        $factory = $this->app->make(ContainerAwareClientFactory::class);

        $client = $factory->make(null, 'machine-man-preview');

        $this->assertInstanceOf(Client::class, $client);
        $this->assertSame('machine-man-preview', $client->getApiVersion());
    }
}
