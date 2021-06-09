<?php

namespace Tests\Unit\GitHub;

use BabDev\Contracts\GitHub\JWTConfigurationBuilder;
use BabDev\GitHub\JWTTokenGenerator;
use Lcobucci\JWT\Configuration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class JWTTokenGeneratorTest extends TestCase
{
    /** @test */
    public function the_generator_generates_a_jwt_token_for_a_repository(): void
    {
        $repoConfig = [
            'app_id' => 12345,
            'key' => \dirname(__DIR__) . '/../fixtures/private-key.pem',
        ];

        $config = Configuration::forUnsecuredSigner();

        /** @var MockObject&JWTConfigurationBuilder $builder */
        $builder = $this->createMock(JWTConfigurationBuilder::class);
        $builder->expects($this->once())
            ->method('build')
            ->with($repoConfig)
            ->willReturn($config);

        $this->assertNotEmpty(
            (new JWTTokenGenerator($builder))->generate($repoConfig)
        );
    }
}
