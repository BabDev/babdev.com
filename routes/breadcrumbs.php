<?php

use BabDev\Breadcrumbs\Contracts\BreadcrumbsGenerator;
use BabDev\Breadcrumbs\Contracts\BreadcrumbsManager;
use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use BabDev\Models\PackageVersion;

/** @var BreadcrumbsManager $breadcrumbs */
$breadcrumbs->for(
    'homepage',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->push('Home', route('homepage'));
    },
);

$breadcrumbs->for(
    'privacy',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Privacy', route('privacy'));
    },
);

$breadcrumbs->for(
    'sponsor',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Sponsor', route('sponsor'));
    },
);

$breadcrumbs->for(
    'open-source.packages',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Packages', route('open-source.packages'));
    },
);

$breadcrumbs->for(
    'open-source.packages.package-docs-page',
    static function (BreadcrumbsGenerator $trail, Package $package, ?PackageVersion $packageVersion, ?string $title): void {
        $trail->parent('open-source.packages');
        $trail->push($package->display_name);

        if (!$packageVersion instanceof PackageVersion) {
            $trail->push('Documentation');
        } else {
            $trail->push(sprintf('Documentation (%s)', $packageVersion->version));
        }

        if ($title !== null) {
            $trail->push($title);
        }
    },
);

$breadcrumbs->for(
    'open-source.update',
    static function (BreadcrumbsGenerator $trail, PackageUpdate $packageUpdate): void {
        $trail->parent('open-source.updates');
        $trail->push($packageUpdate->title, route('open-source.update', ['update' => $packageUpdate]));
    },
);

$breadcrumbs->for(
    'open-source.updates',
    static function (BreadcrumbsGenerator $trail): void {
        $trail->parent('homepage');
        $trail->push('Open Source');
        $trail->push('Updates', route('open-source.updates'));
    },
);
