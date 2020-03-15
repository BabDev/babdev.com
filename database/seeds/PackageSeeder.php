<?php

use BabDev\Models\Package;
use BabDev\PackageType;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * @var \DateTimeZone
     */
    private $utc;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->utc = new \DateTimeZone('UTC');

        $this->fixBabDevPagerfantaBundle();
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
                    'package_type' => PackageType::SYMFONY_BUNDLE,
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
                    'has_local_releases' => true,
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
                    'has_local_releases' => true,
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
                    'has_local_releases' => true,
                ]
            );
    }
}
