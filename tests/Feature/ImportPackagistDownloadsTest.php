<?php

namespace Tests\Feature;

use BabDev\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Spatie\Packagist\PackagistClient;
use Tests\TestCase;

final class ImportPackagistDownloadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_downloads_for_packagist_listings_are_imported(): void
    {
        Package::factory()->packagist()->create();

        $this->mock(PackagistClient::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPackage')->andReturn([
                'package' => [
                    'downloads' => [
                        'total' => random_int(0, 999999),
                    ],
                ],
            ]);
        });

        $this->artisan('import:packagist-downloads')
            ->assertSuccessful();
    }
}
