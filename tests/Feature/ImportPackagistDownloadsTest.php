<?php

namespace Tests\Feature;

use BabDev\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Spatie\Packagist\PackagistClient;
use Tests\TestCase;

class ImportPackagistDownloadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function downloads_for_packagist_listings_are_imported(): void
    {
        Package::factory()->packagist()->create();

        $this->instance(
            PackagistClient::class,
            \Mockery::mock(PackagistClient::class, function (MockInterface $mock): void {
                $mock->shouldReceive('getPackage')->andReturn(
                    [
                        'package' => [
                            'downloads' => [
                                'total' => random_int(0, 999999),
                            ],
                        ],
                    ]
                );
            })
        );

        $this->artisan('import:packagist-downloads')
            ->assertExitCode(0);
    }
}
