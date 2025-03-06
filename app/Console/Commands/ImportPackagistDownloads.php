<?php

namespace BabDev\Console\Commands;

use BabDev\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'import:packagist-downloads', description: 'Import download counts from Packagist.')]
final class ImportPackagistDownloads extends Command
{
    protected $name = 'import:packagist-downloads';

    protected $description = 'Import download counts from Packagist.';

    public function handle(): void
    {
        $this->components->info('Fetching download counts...');

        Package::isPackagist()->each(function (Package $package): void {
            \assert($package->packagist_name !== null);

            $this->components->info("Importing `{$package->name}` downloads... ");

            $stats = Http::withUserAgent('BabDev/1.0')
                ->get("https://packagist.org/packages/{$package->packagist_name}/stats.json");

            if ($stats->failed()) {
                $this->components->error("Could not fetch the `{$package->name}` download stats... ");

                return;
            }

            $package->update([
                'downloads' => $stats->json('downloads.total'),
            ]);
        });

        $this->components->success('All done!');
    }
}
