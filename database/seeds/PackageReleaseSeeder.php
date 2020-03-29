<?php

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use BabDev\ReleaseStability;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PackageReleaseSeeder extends Seeder
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

        $this->loadPodcastManager();
        $this->loadTweetDisplayBack();
        $this->loadYetAnotherSocialPlugin();
    }

    private function loadPodcastManager(): void
    {
        /** @var Package $podcastManager */
        $podcastManager = Package::query()->where('name', '=', 'Podcast-Manager')->firstOrFail();

        $releaseData = [
            [
                'version' => '1.6.alpha',
                'slug' => '1-6-alpha',
                'maturity' => ReleaseStability::ALPHA,
                'summary' => '<p>This is the first alpha release of Podcast Manager. Since it is in an alpha status, it is not considered production ready. As well, much of the planned functionality of the suite of extensions is not fully integrated at this time, although much of the framework is in place.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 3, 20, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '1.6.beta',
                'slug' => '1-6-beta',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This is the first beta release of Podcast Manager.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 3, 28, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '1.6.beta2',
                'slug' => '1-6-beta2',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This is the second beta release of Podcast Manager. In addition to addressing bugs from the previous beta release, support for one-click updates has been added as well as the creation of optional overrides packages for core Joomla templates.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 4, 4, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '1.6.0',
                'slug' => '1-6-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is the first stable release of Podcast Manager.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 4, 13, 16, 0, 0, $this->utc),
            ],
            [
                'version' => '1.6.1',
                'slug' => '1-6-1',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a security and maintenance release of Podcast Manager addressing bugs discovered after the original release and addressing similar security issues fixed in Joomla 1.6.2.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 4, 19, 17, 30, 0, $this->utc),
            ],
            [
                'version' => '1.7.beta',
                'slug' => '1-7-beta',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This is the first beta release of Podcast Manager 1.7. The new release adds support for multiple podcast feeds.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 5, 3, 17, 30, 0, $this->utc),
            ],
            [
                'version' => '1.7.beta2',
                'slug' => '1-7-beta2',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This is the second beta release of Podcast Manager 1.7. This release addresses several minor bugs found after the first beta release.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 5, 21, 14, 0, 0, $this->utc),
            ],
            [
                'version' => '1.7.0',
                'slug' => '1-7-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is the stable release of Podcast Manager 1.7. The new release adds support for multiple podcast feeds and includes various bug fixes and optimizations.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 6, 18, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '1.7.1',
                'slug' => '1-7-1',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager which addresses bugs found after the 1.7.0 release and adds support for Joomla 1.7.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 7, 19, 1, 0, 0, $this->utc),
            ],
            [
                'version' => '1.7.2',
                'slug' => '1-7-2',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager which fixes the toolbars in the admin component broken after the 1.7.1 release.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 7, 25, 0, 15, 0, $this->utc),
            ],
            [
                'version' => '1.8.alpha',
                'slug' => '1-8-alpha',
                'maturity' => ReleaseStability::ALPHA,
                'summary' => '<p>This is the first alpha release of Podcast Manager 1.8. The new release adds several new frontend capabilities for the component allowing users to better integrate podcast feeds into their sites.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 5, 3, 17, 30, 0, $this->utc),
            ],
            [
                'version' => '1.8.beta',
                'slug' => '1-8-beta',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This is the first beta release of Podcast Manager 1.8. This beta release builds on the previous alpha release and adds a new frontend media player to the component.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 7, 26, 5, 45, 0, $this->utc),
            ],
            [
                'version' => '1.8.0',
                'slug' => '1-8-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is the stable release of Podcast Manager 1.8. The new release adds several new frontend capabilities for the component allowing users to better integrate podcast feeds into their sites, including a new frontend media player.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 8, 8, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '1.8.1',
                'slug' => '1-8-1',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager 1.8 addressing several bugs including missing fields on the frontend edit views, a K2 compatibility issue, and a bug causing the feed module to not limit the number of displayed items.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 10, 17, 13, 0, 0, $this->utc),
            ],
            [
                'version' => '1.8.2',
                'slug' => '1-8-2',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager 1.8 addressing a critical bug which broke the update check mechanism in the component\'s backend.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 10, 17, 20, 30, 0, $this->utc),
            ],
            [
                'version' => '1.8.3',
                'slug' => '1-8-3',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager 1.8 addressing some minor bugs impacting the frontend pages and RSS feed generation.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2012, 2, 10, 20, 30, 0, $this->utc),
            ],
            [
                'version' => '2.0.0',
                'slug' => '2-0-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>Podcast Manager 2.0 is a major overhaul of the extension suite which adds several new features including Joomla 2.5 support, multi-database support, a new frontend media player, and integration with Smart Search.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2012, 5, 23, 11, 0, 0, $this->utc),
            ],
            [
                'version' => '2.0.1',
                'slug' => '2-0-1',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is a maintenance release of Podcast Manager 2.0 addressing a bug impacting extension updates and adds a link to a feed\'s frontend RSS URL to the backend list.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2012, 5, 24, 17, 40, 0, $this->utc),
            ],
            [
                'version' => '2.1.0.rc',
                'slug' => '2-1-0-rc',
                'maturity' => ReleaseStability::RC,
                'summary' => '<p>This is release candidate for Podcast Manager 2.1. The new release adds support for Joomla 3.x, including Joomla 3.1\'s tagging feature, and adds support for using various podcast analytics services.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2013, 7, 3, 0, 0, 0, $this->utc),
            ],
            [
                'version' => '2.1.0',
                'slug' => '2-1-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>Podcast Manager 2.1 is a feature update which adds support for Joomla 3.x, including Joomla 3.1\'s tagging feature, and adds support for using various podcast analytics services.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2013, 8, 28, 17, 0, 0, $this->utc),
            ],
            [
                'version' => '2.2.0',
                'slug' => '2-2-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>Podcast Manager 2.2 is a feature update adding support for Joomla\'s content versioning feature and improves support for sites upgrading from Joomla! 2.5 to 3.x.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2015, 6, 22, 14, 0, 0, $this->utc),
            ],
        ];

        foreach ($releaseData as $release) {
            $this->createReleaseWithMedia($podcastManager, $release);
        }
    }

    private function loadTweetDisplayBack(): void
    {
        /** @var Package $tweetDisplayBack */
        $tweetDisplayBack = Package::query()->where('name', '=', 'Tweet-Display-Back')->firstOrFail();
    }

    private function loadYetAnotherSocialPlugin(): void
    {
        /** @var Package $yetAnotherSocialPlugin */
        $yetAnotherSocialPlugin = Package::query()->where('name', '=', 'Yet-Another-Social-Plugin')->firstOrFail();

        $releaseData = [
            [
                'version' => '1.0.0',
                'slug' => '1-0-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This is the initial release of this social plugin.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 7, 28, 3, 0, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_100.zip',
                        'display_title' => 'Yet Another Social Plugin 1.0.0',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
            [
                'version' => '1.0.1',
                'slug' => '1-0-1',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>This release of Yet Another Social Plugin adds the ability to choose where the plugin is displayed in the article, adds three translations, and allows users to create a customized default.css.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 8, 12, 17, 0, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_101.zip',
                        'display_title' => 'Yet Another Social Plugin 1.0.1',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
            [
                'version' => '1.1.beta',
                'slug' => '1-1-beta',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This release of Yet Another Social Plugin adds the Google Buzz and LinkedIn Share buttons as well as enhances international support.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2011, 9, 17, 13, 0, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_11beta.zip',
                        'display_title' => 'Yet Another Social Plugin 1.1 Beta',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
            [
                'version' => '1.1.beta2',
                'slug' => '1-1-beta2',
                'maturity' => ReleaseStability::BETA,
                'summary' => '<p>This release of Yet Another Social Plugin adds the LinkedIn Share button as well as enhances international support.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2012, 1, 16, 13, 30, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_1.1.beta2.zip',
                        'display_title' => 'Yet Another Social Plugin 1.1 Beta 2',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
            [
                'version' => '1.1.0',
                'slug' => '1-1-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>The 1.1 release series brings in three major new features. Visible to the user is the addition of the LinkedIn button. Invisible to the user is that the plugin now contains advanced processing logic to dynamically set each button\'s language based on first the article\'s settings, followed by the site\'s configuration, and falling back on English if your language is not available. Lastly, the ability to choose the views the buttons are displayed in has been added.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2012, 10, 23, 23, 0, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_1.1.0.zip',
                        'display_title' => 'Yet Another Social Plugin 1.1.0',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
            [
                'version' => '2.0.0',
                'slug' => '2-0-0',
                'maturity' => ReleaseStability::STABLE,
                'summary' => '<p>The 2.0 release is optimized for Joomla! 3.4 and adopts the core conventions for media and template paths within plugins. The plugin\'s code is restructured to enable proper HTTPS support on all sites and improves the supported languages with each API provider. Additionally the manner in which the Facebook Like button is built is updated for the current API support.</p>',
                'changelog' => '',
                'visible' => true,
                'released_at' => Carbon::create(2015, 6, 22, 14, 0, 0, $this->utc),
                'files' => [
                    [
                        'filename' => 'plg_content_yetanothersocial_2.0.0.zip',
                        'display_title' => 'Yet Another Social Plugin 2.0.0',
                        'description' => 'This is the installation package for Yet Another Social Plugin.',
                    ],
                ],
            ],
        ];

        foreach ($releaseData as $release) {
            $this->createReleaseWithMedia($yetAnotherSocialPlugin, $release);
        }
    }

    private function createReleaseWithMedia(Package $package, array $release): void
    {
        $files = $release['files'] ?? [];
        unset($release['files']);

        /** @var PackageRelease $packageRelease */
        $packageRelease = $package->releases()->firstOrCreate(
            [
                'version' => $release['version'],
            ],
            $release
        );

        foreach ($files as $file) {
            if (file_exists(storage_path("app/packages/{$file['filename']}"))) {
                $packageRelease->copyMedia(storage_path("app/packages/{$file['filename']}"))
                    ->toMediaCollection('downloads')
                    ->setCustomProperty('display_title', $file['display_title'])
                    ->setCustomProperty('description', $file['description'])
                    ->save();
            }
        }
    }
}
