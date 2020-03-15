<?php

use BabDev\Models\Package;
use BabDev\Models\PackageRelease;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;

/** @var BreadcrumbsManager $breadcrumbs */

$breadcrumbs->for(
    'homepage',
    static function (BreadcrumbsGenerator $trail) {
        $trail->push('Home', route('homepage'));
    }
);

$breadcrumbs->for(
    'privacy',
    static function (BreadcrumbsGenerator $trail) {
        $trail->parent('homepage');
        $trail->push('Privacy', route('privacy'));
    }
);

$breadcrumbs->for(
    'open-source.packages',
    static function (BreadcrumbsGenerator $trail) {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Packages', route('open-source.packages'));
    }
);

$breadcrumbs->for(
    'open-source.package.releases',
    static function (BreadcrumbsGenerator $trail, Package $package) {
        $trail->parent('open-source.packages');
        $trail->push($package->name);
        $trail->push('Releases', route('open-source.package.releases', ['package' => $package]));
    }
);

$breadcrumbs->for(
    'open-source.package.release',
    static function (BreadcrumbsGenerator $trail, Package $package, PackageRelease $release) {
        $trail->parent('open-source.package.releases', $package);
        $trail->push($release->version, route('open-source.package.release', ['package' => $package, 'package_release' => $release]));
    }
);
