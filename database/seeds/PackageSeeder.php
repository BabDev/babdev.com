<?php

use BabDev\Models\Package;
use BabDev\PackageType;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $this->fixBabDevPagerfantaBundle();
        $this->fixLaravelBreadcrumbs();
        $this->fixLaravelServerPushManager();
        $this->fixLaravelTwilio();
        $this->fixPodcastManager();
        $this->fixSupplierPlugin();
        $this->fixTransifexApi();
        $this->fixTweetDisplayBack();
        $this->fixYetAnotherSocialPlugin();
    }

    private function fixBabDevPagerfantaBundle(): void
    {
        Package::query()
            ->where('name', '=', 'BabDevPagerfantaBundle')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/pagerfanta-bundle',
                    'package_type' => PackageType::SYMFONY_BUNDLE,
                ]
            );
    }

    private function fixLaravelBreadcrumbs(): void
    {
        Package::query()
            ->where('name', '=', 'laravel-breadcrumbs')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/laravel-breadcrumbs',
                    'package_type' => PackageType::LARAVEL_PACKAGE,
                ]
            );
    }

    private function fixLaravelServerPushManager(): void
    {
        Package::query()
            ->where('name', '=', 'laravel-server-push-manager')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/laravel-server-push-manager',
                    'package_type' => PackageType::LARAVEL_PACKAGE,
                ]
            );
    }

    private function fixLaravelTwilio(): void
    {
        Package::query()
            ->where('name', '=', 'laravel-twilio')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/laravel-twilio',
                    'package_type' => PackageType::LARAVEL_PACKAGE,
                ]
            );
    }

    private function fixPodcastManager(): void
    {
        Package::query()
            ->where('name', '=', 'Podcast-Manager')
            ->firstOrFail()
            ->update(
                [
                    'logo' => 'podcast-manager.svg',
                    'package_type' => PackageType::JOOMLA_EXTENSION,
                    'is_packagist' => false,
                ]
            );
    }

    private function fixSupplierPlugin(): void
    {
        Package::query()
            ->where('name', '=', 'supplier-plugin')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/supplier-plugin',
                    'package_type' => PackageType::SYLIUS_PLUGIN,
                ]
            );
    }

    private function fixTransifexApi(): void
    {
        Package::query()
            ->where('name', '=', 'Transifex-API')
            ->firstOrFail()
            ->update(
                [
                    'packagist_name' => 'babdev/transifex',
                    'package_type' => PackageType::PHP_PACKAGE,
                ]
            );
    }

    private function fixTweetDisplayBack(): void
    {
        Package::query()
            ->where('name', '=', 'Tweet-Display-Back')
            ->firstOrFail()
            ->update(
                [
                    'logo' => 'tweet-display-back.svg',
                    'package_type' => PackageType::JOOMLA_EXTENSION,
                    'is_packagist' => false,
                ]
            );
    }

    private function fixYetAnotherSocialPlugin(): void
    {
        Package::query()
            ->where('name', '=', 'Yet-Another-Social-Plugin')
            ->firstOrFail()
            ->update(
                [
                    'logo' => 'yet-another-social-plugin.svg',
                    'package_type' => PackageType::JOOMLA_EXTENSION,
                    'is_packagist' => false,
                ]
            );
    }
}
