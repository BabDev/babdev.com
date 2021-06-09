<?php

namespace Database\Seeders;

use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PackageUpdateSeeder extends Seeder
{
    private ?\DateTimeZone $utc;

    public function run(): void
    {
        $this->utc = new \DateTimeZone('UTC');

        /** @var Package $pagerfantaBundle */
        $pagerfantaBundle = Package::query()->where('name', '=', 'PagerfantaBundle')->firstOrFail();

        $pagerfanta22Update = new PackageUpdate(
            [
                'title' => 'Twig Support Added to Pagerfanta Bundle',
                'intro' => '<p>The latest version of PagerfantaBundle is now available which includes support for Twig generated Pagerfanta views.</p>',
                'content' => '<p>The latest version of PagerfantaBundle is now available which includes support for Twig generated Pagerfanta views.</p>
<p>Starting with the 2.2 release, the bundle extends Pagerfanta to introduce a new <code>TwigView</code> which allows pagers to be rendered fully with the <a href="https://twig.symfony.com" rel="nofollow noopener">Twig</a> templating engine. This gives designers full control over the rendered markup for their pagers and allows the templating integration to be fully customized to a site\'s requirements without having to modify a number of PHP classes.</p>
<p>With the creation of the <code>TwigView</code>, the translated Pagerfanta views have been deprecated and will be removed in 3.0. The Twig templates use the same translated strings that the translated view decorators use to allow the messages to be translated, and is a simpler integration in general compared to the translated view decorator classes which require special handling to make the translations work. Therefore, the new <code>TwigView</code> is the preferred way of customizing the output created by Pagerfanta.</p>
<p>Other changes in the 2.2 release include:</p>
<ul>
    <li>Extracted Route Generators - The route generator logic was hardcoded into the Twig extension and if your application had router logic that did not follow the Twig extension\'s setup then you were left to implement your own Twig integration. The route generators have been extracted to a separate API that can be fully customized. This also makes it easier to use the bundle in API only contexts where a response may generate paginated URLs to include in a response.</li>
    <li>Configuration Deprecations - The <code>babdev_pagerfanta.exceptions_strategy.out_of_range_page</code> and <code>babdev_pagerfanta.exceptions_strategy.not_valid_current_page</code> configuration nodes have had the ability to set them to any value deprecated. These nodes only support two strategies, either the default 404 handling provided by the bundle or a custom strategy for your application, this deprecation updates the configuration to match this behavior.</li>
</ul>
<p>Please see the <a href="https://github.com/BabDev/PagerfantaBundle/blob/v2.2.0/CHANGELOG.md" rel="nofollow noopener">CHANGELOG</a> for all changes in this bundle.</p>',
                'published_at' => Carbon::create(2020, 4, 18, 15, 0, 0, $this->utc),
            ]
        );
        $pagerfanta22Update->package()->associate($pagerfantaBundle);
        $pagerfanta22Update->save();

        /** @var Package $breadcrumbsPackage */
        $breadcrumbsPackage = Package::query()->where('name', '=', 'laravel-breadcrumbs')->firstOrFail();

        $breadcrumbsReleaseUpdate = new PackageUpdate(
            [
                'title' => 'Introducing Laravel Breadcrumbs',
                'intro' => '<p>Today I am pleased to announce the stable release of my new Laravel Breadcrumbs package.</p>',
                'content' => '<p>Today I am pleased to announce the stable release of my new Laravel Breadcrumbs package.</p>
<p>The Laravel Breadcrumbs package is a continuation of the <a href="https://github.com/davejamesmiller/laravel-breadcrumbs" rel="nofollow noopener"><code>davejamesmiller/laravel-breadcrumbs</code></a> package which is no longer being maintained by the package author, and is used on this site to render the breadcrumb bar on each page.</p>
<p>Though this is a continuation, there are also a number of breaking changes required to migrate to the new package, these are covered in the <a href="https://github.com/BabDev/laravel-breadcrumbs/blob/1.0.0/UPGRADE.md" rel="nofollow noopener">upgrade guide</a> for the 1.0 release.</p>',
                'published_at' => Carbon::create(2020, 4, 28, 15, 0, 0, $this->utc),
            ]
        );
        $breadcrumbsReleaseUpdate->package()->associate($breadcrumbsPackage);
        $breadcrumbsReleaseUpdate->save();
    }
}
