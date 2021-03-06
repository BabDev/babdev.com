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

    private PackagistClient $packagist;

    public function __construct(PackagistClient $packagist)
    {
        $this->packagist = $packagist;

        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Fetching download counts...');

        Package::query()->isPackagist()->get()->each(
            function (Package $package): void {
                $this->comment("Importing `{$package->name}` downloads... ");

                [$vendor, $packageName] = explode('/', $package->packagist_name);

                $packagistInfo = $this->packagist->getPackage($vendor, $packageName);

                $package->update(
                    [
                        'downloads' => Arr::get($packagistInfo, 'package.downloads.total'),
                    ]
                );
            }
        );

        $this->info('All done!');
    }
}
