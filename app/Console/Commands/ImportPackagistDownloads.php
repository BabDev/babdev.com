<?php

namespace App\Console\Commands;

use App\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'import:packagist-downloads', description: 'Import download counts from Packagist.')]
final class ImportPackagistDownloads extends Command
{
    public function handle(): void
    {
        $this->components->info('Fetching download counts...');

        Package::isPackagist()->each(function (Package $package): void {
            \assert($package->packagist_name !== null);

            $this->components->info("Importing `$package->name` downloads... ");

            $stats = Http::get("https://packagist.org/packages/$package->packagist_name/stats.json");

            if ($stats->failed()) {
                $this->components->error("Could not fetch the `$package->name` download stats... ");

                return;
            }

            $package->updateQuietly([
                'downloads' => $stats->json('downloads.total'),
            ]);
        });

        $this->components->success('All done!');
    }
}
