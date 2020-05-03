<?php

use BabDev\Breadcrumbs\Contracts\BreadcrumbsGenerator;
use BabDev\Breadcrumbs\Contracts\BreadcrumbsManager;
use BabDev\Models\PackageUpdate;

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
    'open-source.update',
    static function (BreadcrumbsGenerator $trail, PackageUpdate $packageUpdate): void {
        $trail->parent('open-source.updates');
        $trail->push($packageUpdate->title, route('open-source.update', ['update' => $packageUpdate]));
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
