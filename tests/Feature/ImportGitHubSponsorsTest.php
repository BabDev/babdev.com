<?php

namespace Tests\Feature;

use BabDev\GitHub\ApiConnector;
use BabDev\Models\SponsorshipTier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

final class ImportGitHubSponsorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_sponsors_tiers_are_imported(): void
    {
        /** @var SponsorshipTier $tier1 */
        $tier1 = SponsorshipTier::query()->create([
            'node_id' => 'node-1',
            'one_time' => false,
            'price' => 2500,
        ]);

        /** @var SponsorshipTier $tier2 */
        $tier2 = SponsorshipTier::query()->create([
            'node_id' => 'node-2',
            'one_time' => true,
            'price' => 2500,
        ]);

        $this->mock(ApiConnector::class, function (MockInterface $mock): void {
            $mock->shouldReceive('executeGraphqlQuery')->once()->andReturn([
                'data' => [
                    'viewer' => [
                        'sponsorshipsAsMaintainer' => [
                            'edges' => [
                                [
                                    'node' => [
                                        'id' => 'node-1',
                                        'privacyLevel' => 'PUBLIC',
                                        'sponsorEntity' => [
                                            'id' => 'node-1',
                                            'login' => 'username1',
                                            'name' => 'Username 1',
                                        ],
                                        'tier' => [
                                            'id' => 'node-1',
                                        ],
                                    ],
                                ],
                                [
                                    'node' => [
                                        'id' => 'node-2',
                                        'privacyLevel' => 'PRIVATE',
                                        'sponsorEntity' => [
                                            'id' => 'node-2',
                                            'login' => 'username2',
                                            'name' => null,
                                        ],
                                        'tier' => [
                                            'id' => 'node-2',
                                        ],
                                    ],
                                ],
                            ],
                            'pageInfo' => [
                                'hasNextPage' => false,
                                'endCursor' => 'node-2',
                            ],
                        ],
                    ],
                ],
            ]);
        });

        $this->artisan('import:github-sponsors')
            ->assertExitCode(0);

        $this->assertDatabaseCount('sponsors', 2);
    }
}
