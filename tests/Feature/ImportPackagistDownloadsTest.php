<?php

namespace Tests\Feature;

use BabDev\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class ImportPackagistDownloadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_downloads_for_packagist_listings_are_imported(): void
    {
        $package = Package::factory()->packagist()->create();

        $totalDownloads = random_int(10000, 999999);
        $monthlyDownloads = random_int(100, $totalDownloads);
        $dailyDownloads = random_int(0, $monthlyDownloads);

        Http::fake([
            "packagist.org/packages/{$package->packagist_name}/stats.json" => Http::response([
                'downloads' => [
                    'total' => $totalDownloads,
                    'monthly' => $monthlyDownloads,
                    'daily' => $dailyDownloads,
                ],
                'versions' => [
                    'dev-main',
                ],
                'average' => 'monthly',
                'date' => '2025-03-05',
            ]),
        ]);

        $this->artisan('import:packagist-downloads')
            ->assertSuccessful();

        $this->assertDatabaseHas('packages', ['id' => $package->id, 'downloads' => $totalDownloads]);
    }
}
