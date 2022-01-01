<?php

namespace BabDev\Console\Commands;

use BabDev\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Spatie\Packagist\PackagistClient;

class ImportPackagistDownloads extends Command
{
    protected $name = 'import:packagist-downloads';

    protected $description = 'Import download counts from Packagist.';

    public function handle(PackagistClient $packagist): void
    {
        $this->info('Fetching download counts...');

        Package::query()->isPackagist()->each(function (Package $package) use ($packagist): void {
            $this->comment("Importing `{$package->name}` downloads... ");

            [$vendor, $packageName] = explode('/', $package->packagist_name);

            $packagistInfo = $packagist->getPackage($vendor, $packageName);

            $package->update(
                [
                    'downloads' => Arr::get($packagistInfo, 'package.downloads.total'),
                ],
            );
        });

        $this->info('All done!');
    }
}
