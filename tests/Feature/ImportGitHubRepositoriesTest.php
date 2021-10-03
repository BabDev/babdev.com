<?php

namespace Tests\Feature;

use BabDev\GitHub\ApiConnector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ImportGitHubRepositoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_public_repositories_are_imported(): void
    {
        $this->instance(
            ApiConnector::class,
            \Mockery::mock(ApiConnector::class, function (MockInterface $mock): void {
                $mock->shouldReceive('fetchPublicRepositories')->once()->andReturn(
                    collect(
                        [
                            [
                                'name' => 'babdev.com',
                                'description' => 'The babdev.com source code',
                                'stargazers_count' => 1,
                                'language' => 'PHP',
                                'archived' => false,
                            ],
                            [
                                'name' => 'Pagerfanta',
                                'description' => 'Pagination library for PHP applications with support for several data providers',
                                'stargazers_count' => 144,
                                'language' => 'PHP',
                                'archived' => false,
                            ],
                            [
                                'name' => 'Podcast-Manager',
                                'description' => 'Podcast Manager is a suite of extensions allowing users to host and manage a podcast feed from their Joomla! site.',
                                'stargazers_count' => 39,
                                'language' => 'PHP',
                                'archived' => true,
                            ],
                        ],
                    ),
                );
                $mock->shouldReceive('fetchRepositoryTopics')->twice()->andReturn(collect());
            }),
        );

        $this->artisan('import:github-repositories')
            ->assertExitCode(0);

        $this->assertDatabaseCount('packages', 2);
    }
}
