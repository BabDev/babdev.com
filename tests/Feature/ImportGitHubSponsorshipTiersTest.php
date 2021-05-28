<?php

namespace Tests\Feature;

use BabDev\GitHub\ApiConnector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ImportGitHubSponsorshipTiersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_sponsorship_tiers_are_imported()
    {
        $this->instance(
            ApiConnector::class,
            \Mockery::mock(
                ApiConnector::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('executeGraphqlQuery')->once()->andReturn(
                        [
                            'data' => [
                                'viewer' => [
                                    'sponsorsListing' => [
                                        'tiers' => [
                                            'edges' => [
                                                [
                                                    'node' => [
                                                        'id' => 'node-1',
                                                        'name' => '$1 a month',
                                                        'isOneTime' => false,
                                                        'monthlyPriceInCents' => 100,
                                                    ],
                                                ],
                                                [
                                                    'node' => [
                                                        'id' => 'node-2',
                                                        'name' => '$5 a month',
                                                        'isOneTime' => false,
                                                        'monthlyPriceInCents' => 500,
                                                    ],
                                                ],
                                                [
                                                    'node' => [
                                                        'id' => 'node-3',
                                                        'name' => '$5 one time',
                                                        'isOneTime' => true,
                                                        'monthlyPriceInCents' => 500,
                                                    ],
                                                ],
                                            ],
                                            'pageInfo' => [
                                                'hasNextPage' => false,
                                                'endCursor' => 'node-3',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ]
                    );
                }
            )
        );

        $this->artisan('import:github-sponsorship-tiers')
            ->assertExitCode(0);

        $this->assertDatabaseCount('sponsorship_tiers', 3);
    }
}
