<?php

use BabDev\Models\JoomlaExtension;
use BabDev\Models\JoomlaExtensionRelease;
use BabDev\ReleaseStability;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JoomlaExtensionReleaseSeeder extends Seeder
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
        $podcastManager = JoomlaExtension::query()->where('name', '=', 'Podcast Manager')->firstOrFail();

        $v16alphaRelease = new JoomlaExtensionRelease();
        $v16alphaRelease->version = '1.6.alpha';
        $v16alphaRelease->slug = '1-6-alpha';
        $v16alphaRelease->maturity = ReleaseStability::ALPHA;
        $v16alphaRelease->summary = '<p>This is the first alpha release of Podcast Manager. Since it is in an alpha status, it is not considered production ready. As well, much of the planned functionality of the suite of extensions is not fully integrated at this time, although much of the framework is in place.</p>';
        $v16alphaRelease->changelog = '';
        $v16alphaRelease->published = true;
        $v16alphaRelease->published_at = Carbon::create(2011, 3, 20, 0, 0, 0, $this->utc);
        $v16alphaRelease->extension()->associate($podcastManager);
        $v16alphaRelease->save();

        $v16betaRelease = new JoomlaExtensionRelease();
        $v16betaRelease->version = '1.6.beta';
        $v16betaRelease->slug = '1-6-beta';
        $v16betaRelease->maturity = ReleaseStability::BETA;
        $v16betaRelease->summary = '<p>This is the first beta release of Podcast Manager.</p>';
        $v16betaRelease->changelog = '';
        $v16betaRelease->published = true;
        $v16betaRelease->published_at = Carbon::create(2011, 3, 28, 0, 0, 0, $this->utc);
        $v16betaRelease->extension()->associate($podcastManager);
        $v16betaRelease->save();

        $v16beta2Release = new JoomlaExtensionRelease();
        $v16beta2Release->version = '1.6.beta2';
        $v16beta2Release->slug = '1-6-beta2';
        $v16beta2Release->maturity = ReleaseStability::BETA;
        $v16beta2Release->summary = '<p>This is the second beta release of Podcast Manager. In addition to addressing bugs from the previous beta release, support for one-click updates has been added as well as the creation of optional overrides packages for core Joomla templates.</p>';
        $v16beta2Release->changelog = '';
        $v16beta2Release->published = true;
        $v16beta2Release->published_at = Carbon::create(2011, 4, 4, 0, 0, 0, $this->utc);
        $v16beta2Release->extension()->associate($podcastManager);
        $v16beta2Release->save();

        $v160Release = new JoomlaExtensionRelease();
        $v160Release->version = '1.6.0';
        $v160Release->slug = '1-6-0';
        $v160Release->maturity = ReleaseStability::STABLE;
        $v160Release->summary = '<p>This is the first stable release of Podcast Manager.</p>';
        $v160Release->changelog = '';
        $v160Release->published = true;
        $v160Release->published_at = Carbon::create(2011, 4, 13, 16, 0, 0, $this->utc);
        $v160Release->extension()->associate($podcastManager);
        $v160Release->save();

        $v161Release = new JoomlaExtensionRelease();
        $v161Release->version = '1.6.1';
        $v161Release->slug = '1-6-1';
        $v161Release->maturity = ReleaseStability::STABLE;
        $v161Release->summary = '<p>This is a security and maintenance release of Podcast Manager addressing bugs discovered after the original release and addressing similar security issues fixed in Joomla 1.6.2.</p>';
        $v161Release->changelog = '';
        $v161Release->published = true;
        $v161Release->published_at = Carbon::create(2011, 4, 19, 17, 30, 0, $this->utc);
        $v161Release->extension()->associate($podcastManager);
        $v161Release->save();

        $v17betaRelease = new JoomlaExtensionRelease();
        $v17betaRelease->version = '1.7.beta';
        $v17betaRelease->slug = '1-7-beta';
        $v17betaRelease->maturity = ReleaseStability::BETA;
        $v17betaRelease->summary = '<p>This is the first beta release of Podcast Manager 1.7. The new release adds support for multiple podcast feeds.</p>';
        $v17betaRelease->changelog = '';
        $v17betaRelease->published = true;
        $v17betaRelease->published_at = Carbon::create(2011, 5, 3, 17, 30, 0, $this->utc);
        $v17betaRelease->extension()->associate($podcastManager);
        $v17betaRelease->save();

        $v17beta2Release = new JoomlaExtensionRelease();
        $v17beta2Release->version = '1.7.beta2';
        $v17beta2Release->slug = '1-7-beta2';
        $v17beta2Release->maturity = ReleaseStability::BETA;
        $v17beta2Release->summary = '<p>This is the second beta release of Podcast Manager 1.7. This release addresses several minor bugs found after the first beta release.</p>';
        $v17beta2Release->changelog = '';
        $v17beta2Release->published = true;
        $v17beta2Release->published_at = Carbon::create(2011, 5, 21, 14, 0, 0, $this->utc);
        $v17beta2Release->extension()->associate($podcastManager);
        $v17beta2Release->save();

        $v170Release = new JoomlaExtensionRelease();
        $v170Release->version = '1.7.0';
        $v170Release->slug = '1-7-0';
        $v170Release->maturity = ReleaseStability::STABLE;
        $v170Release->summary = '<p>This is the stable release of Podcast Manager 1.7. The new release adds support for multiple podcast feeds and includes various bug fixes and optimizations.</p>';
        $v170Release->changelog = '';
        $v170Release->published = true;
        $v170Release->published_at = Carbon::create(2011, 6, 18, 0, 0, 0, $this->utc);
        $v170Release->extension()->associate($podcastManager);
        $v170Release->save();

        $v171Release = new JoomlaExtensionRelease();
        $v171Release->version = '1.7.1';
        $v171Release->slug = '1-7-1';
        $v171Release->maturity = ReleaseStability::STABLE;
        $v171Release->summary = '<p>This is a maintenance release of Podcast Manager which addresses bugs found after the 1.7.0 release and adds support for Joomla 1.7.</p>';
        $v171Release->changelog = '';
        $v171Release->published = true;
        $v171Release->published_at = Carbon::create(2011, 7, 19, 1, 0, 0, $this->utc);
        $v171Release->extension()->associate($podcastManager);
        $v171Release->save();

        $v172Release = new JoomlaExtensionRelease();
        $v172Release->version = '1.7.2';
        $v172Release->slug = '1-7-2';
        $v172Release->maturity = ReleaseStability::STABLE;
        $v172Release->summary = '<p>This is a maintenance release of Podcast Manager which fixes the toolbars in the admin component broken after the 1.7.1 release.</p>';
        $v172Release->changelog = '';
        $v172Release->published = true;
        $v172Release->published_at = Carbon::create(2011, 7, 25, 0, 15, 0, $this->utc);
        $v172Release->extension()->associate($podcastManager);
        $v172Release->save();

        $v18alphaRelease = new JoomlaExtensionRelease();
        $v18alphaRelease->version = '1.8.alpha';
        $v18alphaRelease->slug = '1-8-alpha';
        $v18alphaRelease->maturity = ReleaseStability::ALPHA;
        $v18alphaRelease->summary = '<p>This is the first alpha release of Podcast Manager 1.8. The new release adds several new frontend capabilities for the component allowing users to better integrate podcast feeds into their sites.</p>';
        $v18alphaRelease->changelog = '';
        $v18alphaRelease->published = true;
        $v18alphaRelease->published_at = Carbon::create(2011, 5, 3, 17, 30, 0, $this->utc);
        $v18alphaRelease->extension()->associate($podcastManager);
        $v18alphaRelease->save();

        $v18betaRelease = new JoomlaExtensionRelease();
        $v18betaRelease->version = '1.8.beta';
        $v18betaRelease->slug = '1-8-beta';
        $v18betaRelease->maturity = ReleaseStability::BETA;
        $v18betaRelease->summary = '<p>This is the first beta release of Podcast Manager 1.8. This beta release builds on the previous alpha release and adds a new frontend media player to the component.</p>';
        $v18betaRelease->changelog = '';
        $v18betaRelease->published = true;
        $v18betaRelease->published_at = Carbon::create(2011, 7, 26, 5, 45, 0, $this->utc);
        $v18betaRelease->extension()->associate($podcastManager);
        $v18betaRelease->save();

        $v180Release = new JoomlaExtensionRelease();
        $v180Release->version = '1.8.0';
        $v180Release->slug = '1-8-0';
        $v180Release->maturity = ReleaseStability::STABLE;
        $v180Release->summary = '<p>This is the stable release of Podcast Manager 1.8. The new release adds several new frontend capabilities for the component allowing users to better integrate podcast feeds into their sites, including a new frontend media player.</p>';
        $v180Release->changelog = '';
        $v180Release->published = true;
        $v180Release->published_at = Carbon::create(2011, 8, 8, 0, 0, 0, $this->utc);
        $v180Release->extension()->associate($podcastManager);
        $v180Release->save();

        $v181Release = new JoomlaExtensionRelease();
        $v181Release->version = '1.8.1';
        $v181Release->slug = '1-8-1';
        $v181Release->maturity = ReleaseStability::STABLE;
        $v181Release->summary = '<p>This is a maintenance release of Podcast Manager 1.8 addressing several bugs including missing fields on the frontend edit views, a K2 compatibility issue, and a bug causing the feed module to not limit the number of displayed items.</p>';
        $v181Release->changelog = '';
        $v181Release->published = true;
        $v181Release->published_at = Carbon::create(2011, 10, 17, 13, 0, 0, $this->utc);
        $v181Release->extension()->associate($podcastManager);
        $v181Release->save();

        $v182Release = new JoomlaExtensionRelease();
        $v182Release->version = '1.8.2';
        $v182Release->slug = '1-8-2';
        $v182Release->maturity = ReleaseStability::STABLE;
        $v182Release->summary = '<p>This is a maintenance release of Podcast Manager 1.8 addressing a critical bug which broke the update check mechanism in the component\'s backend.</p>';
        $v182Release->changelog = '';
        $v182Release->published = true;
        $v182Release->published_at = Carbon::create(2011, 10, 17, 20, 30, 0, $this->utc);
        $v182Release->extension()->associate($podcastManager);
        $v182Release->save();

        $v183Release = new JoomlaExtensionRelease();
        $v183Release->version = '1.8.3';
        $v183Release->slug = '1-8-3';
        $v183Release->maturity = ReleaseStability::STABLE;
        $v183Release->summary = '<p>This is a maintenance release of Podcast Manager 1.8 addressing some minor bugs impacting the frontend pages and RSS feed generation.</p>';
        $v183Release->changelog = '';
        $v183Release->published = true;
        $v183Release->published_at = Carbon::create(2012, 2, 10, 20, 30, 0, $this->utc);
        $v183Release->extension()->associate($podcastManager);
        $v183Release->save();

        $v200Release = new JoomlaExtensionRelease();
        $v200Release->version = '2.0.0';
        $v200Release->slug = '2-0-0';
        $v200Release->maturity = ReleaseStability::STABLE;
        $v200Release->summary = '<p>Podcast Manager 2.0 is a major overhaul of the extension suite which adds several new features including Joomla 2.5 support, multi-database support, a new frontend media player, and integration with Smart Search.</p>';
        $v200Release->changelog = '';
        $v200Release->published = true;
        $v200Release->published_at = Carbon::create(2012, 5, 23, 11, 0, 0, $this->utc);
        $v200Release->extension()->associate($podcastManager);
        $v200Release->save();

        $v201Release = new JoomlaExtensionRelease();
        $v201Release->version = '2.0.1';
        $v201Release->slug = '2-0-1';
        $v201Release->maturity = ReleaseStability::STABLE;
        $v201Release->summary = '<p>This is a maintenance release of Podcast Manager 2.0 addressing a bug impacting extension updates and adds a link to a feed\'s frontend RSS URL to the backend list.</p>';
        $v201Release->changelog = '';
        $v201Release->published = true;
        $v201Release->published_at = Carbon::create(2012, 5, 24, 17, 40, 0, $this->utc);
        $v201Release->extension()->associate($podcastManager);
        $v201Release->save();

        $v210rcRelease = new JoomlaExtensionRelease();
        $v210rcRelease->version = '2.1.0.rc';
        $v210rcRelease->slug = '2-1-0-rc';
        $v210rcRelease->maturity = ReleaseStability::RC;
        $v210rcRelease->summary = '<p>This is release candidate for Podcast Manager 2.1. The new release adds support for Joomla 3.x, including Joomla 3.1\'s tagging feature, and adds support for using various podcast analytics services.</p>';
        $v210rcRelease->changelog = '';
        $v210rcRelease->published = true;
        $v210rcRelease->published_at = Carbon::create(2013, 7, 3, 0, 0, 0, $this->utc);
        $v210rcRelease->extension()->associate($podcastManager);
        $v210rcRelease->save();

        $v210Release = new JoomlaExtensionRelease();
        $v210Release->version = '2.1.0';
        $v210Release->slug = '2-1-0';
        $v210Release->maturity = ReleaseStability::STABLE;
        $v210Release->summary = '<p>Podcast Manager 2.1 is a feature update which adds support for Joomla 3.x, including Joomla 3.1\'s tagging feature, and adds support for using various podcast analytics services.</p>';
        $v210Release->changelog = '';
        $v210Release->published = true;
        $v210Release->published_at = Carbon::create(2013, 8, 28, 17, 0, 0, $this->utc);
        $v210Release->extension()->associate($podcastManager);
        $v210Release->save();

        $v220Release = new JoomlaExtensionRelease();
        $v220Release->version = '2.2.0';
        $v220Release->slug = '2-2-0';
        $v220Release->maturity = ReleaseStability::STABLE;
        $v220Release->summary = '<p>Podcast Manager 2.2 is a feature update adding support for Joomla\'s content versioning feature and improves support for sites upgrading from Joomla! 2.5 to 3.x.</p>';
        $v220Release->changelog = '';
        $v220Release->published = true;
        $v220Release->published_at = Carbon::create(2015, 6, 22, 14, 0, 0, $this->utc);
        $v220Release->extension()->associate($podcastManager);
        $v220Release->save();
    }

    private function loadTweetDisplayBack(): void
    {
        $tweetDisplayBack = JoomlaExtension::query()->where('name', '=', 'Tweet Display Back')->firstOrFail();
    }

    private function loadYetAnotherSocialPlugin(): void
    {
        $yetAnotherSocialPlugin = JoomlaExtension::query()->where('name', '=', 'Yet Another Social Plugin')->firstOrFail();
    }
}
