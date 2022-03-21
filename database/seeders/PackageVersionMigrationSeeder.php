<?php

namespace Database\Seeders;

use BabDev\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PackageVersionMigrationSeeder extends Seeder
{
    private ?\DateTimeZone $utc;

    public function run(): void
    {
        $this->utc = new \DateTimeZone('UTC');

        $this->seedPodcastManagerVersions();
        $this->seedTweetDisplayBackVersions();
        $this->seedYetAnotherSocialPluginVersions();
        $this->seedTransifexApiVersions();
        $this->seedSupplierPluginVersions();
        $this->seedLaravelServerPushManagerVersions();
        $this->seedPagerfantaBundleVersions();
        $this->seedLaravelTwilioVersions();
        $this->seedLaravelBreadcrumbsVersions();
        $this->seedPagerfantaVersions();
        $this->seedMoneyBundleVersions();
        $this->seedSyliusShippingEstimatePluginVersions();
        $this->seedSyliusProductSamplesPluginVersions();
        $this->seedPhpSpecSkipExampleExtensionVersions();
    }

    private function seedPodcastManagerVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'Podcast-Manager')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2011, 4, 13, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2012, 5, 23, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2012, 5, 23, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2016, 12, 31, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedTweetDisplayBackVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'Tweet-Display-Back')->firstOrFail();

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2011, 7, 21, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2013, 5, 3, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '3.x',
            'released' => Carbon::create(2013, 5, 3, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2016, 12, 31, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedYetAnotherSocialPluginVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'Yet-Another-Social-Plugin')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2011, 7, 27, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2015, 6, 20, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2015, 6, 20, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2016, 12, 31, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedTransifexApiVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'Transifex-API')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2014, 10, 20, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2016, 12, 21, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2016, 12, 21, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2019, 11, 19, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '3.x',
            'released' => Carbon::create(2019, 11, 19, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2020, 1, 1, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedSupplierPluginVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'supplier-plugin')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
        ]);
    }

    private function seedLaravelServerPushManagerVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'laravel-server-push-manager')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2019, 6, 1, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2021, 3, 14, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2021, 3, 14, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedPagerfantaBundleVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'PagerfantaBundle')->firstOrFail();

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2019, 12, 27, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2021, 12, 31, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '3.x',
            'released' => Carbon::create(2021, 3, 7, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedLaravelTwilioVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'laravel-twilio')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2020, 3, 4, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
        ]);
    }

    private function seedLaravelBreadcrumbsVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'laravel-breadcrumbs')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2020, 4, 27, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '2.x',
        ]);
    }

    private function seedPagerfantaVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'Pagerfanta')->firstOrFail();

        $package->versions()->create([
            'version' => '2.x',
            'released' => Carbon::create(2020, 6, 6, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2022, 3, 31, 0, 0, 0, $this->utc),
        ]);

        $package->versions()->create([
            'version' => '3.x',
            'released' => Carbon::create(2021, 3, 7, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedMoneyBundleVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'MoneyBundle')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2021, 2, 28, 0, 0, 0, $this->utc),
        ]);
    }

    private function seedSyliusShippingEstimatePluginVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'SyliusShippingEstimatePlugin')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'docs_git_branch' => '0.1',
        ]);
    }

    private function seedSyliusProductSamplesPluginVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'SyliusProductSamplesPlugin')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'docs_git_branch' => '0.1',
        ]);
    }

    private function seedPhpSpecSkipExampleExtensionVersions(): void
    {
        /** @var Package $package */
        $package = Package::query()->where('name', '=', 'PhpSpecSkipExampleExtension')->firstOrFail();

        $package->versions()->create([
            'version' => '1.x',
            'released' => Carbon::create(2021, 11, 6, 0, 0, 0, $this->utc),
            'end_of_support' => Carbon::create(2022, 1, 17, 0, 0, 0, $this->utc),
        ]);
    }
}
