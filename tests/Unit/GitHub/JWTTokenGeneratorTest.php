<?php

namespace Tests\Unit\GitHub;

use BabDev\GitHub\JWTTokenGenerator;
use PHPUnit\Framework\TestCase;

class JWTTokenGeneratorTest extends TestCase
{
    /** @test */
    public function the_generator_generates_a_jwt_token_for_a_repository()
    {
        $this->assertNotEmpty(
            (new JWTTokenGenerator())->generate(
                [
                    'app_id' => 12345,
                    'key' => \dirname(__DIR__) . '/../fixtures/private-key.pem',
                ]
            )
        );
    }
}
