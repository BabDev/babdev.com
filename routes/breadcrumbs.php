<?php

use BabDev\Breadcrumbs\Contracts\BreadcrumbsGenerator;
use BabDev\Breadcrumbs\Contracts\BreadcrumbsManager;
use BabDev\Models\Package;
use BabDev\Models\PackageRelease;

/** @var BreadcrumbsManager $breadcrumbs */

$breadcrumbs->for(
    'homepage',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->push('Home', route('homepage'));
    }
);

$breadcrumbs->for(
    'privacy',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Privacy', route('privacy'));
    }
);

$breadcrumbs->for(
    'open-source.packages',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Packages', route('open-source.packages'));
    }
);

$breadcrumbs->for(
    'open-source.package.releases',
    static function (BreadcrumbsGenerator $trail, Package $package): void {
        $trail->parent('open-source.packages');
        $trail->push($package->display_name);
        $trail->push('Releases', route('open-source.package.releases', ['package' => $package]));
    }
);

$breadcrumbs->for(
    'open-source.package.release',
    static function (BreadcrumbsGenerator $trail, Package $package, PackageRelease $release): void {
        $trail->parent('open-source.package.releases', $package);
        $trail->push($release->version, route('open-source.package.release', ['package' => $package, 'package_release' => $release]));
    }
);

$breadcrumbs->for(
    'open-source.updates',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Updates', route('open-source.updates'));
    }
);
