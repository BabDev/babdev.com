<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\JWTConfigurationBuilder;
use Lcobucci\JWT\Configuration;
use PHPUnit\Framework\TestCase;

final class JWTConfigurationBuilderTest extends TestCase
{
    /** @test */
    public function the_builder_creates_a_configuration_object_for_a_repository(): void
    {
        $repoConfig = [
            'app_id' => '12345',
            'key' => \dirname(__DIR__) . '/../fixtures/private-key.pem',
            'secret' => 'secret',
            'events' => [],
        ];

        $this->assertInstanceOf(
            Configuration::class,
            (new JWTConfigurationBuilder())->build($repoConfig),
        );
    }
}
