<?php

use BabDev\Http\Controllers\RedirectToPackageDocsController;
use BabDev\Http\Controllers\ViewOpenSourcePackageDocsPageController;
use BabDev\Http\Controllers\ViewOpenSourcePackagesController;
use BabDev\Http\Controllers\ViewOpenSourceUpdateController;
use BabDev\Http\Controllers\ViewOpenSourceUpdatesController;
use BabDev\Http\Controllers\ViewSitemapController;
use BabDev\Http\Controllers\ViewSponsorPageController;
use Illuminate\Routing\Router;

/** @var Router $router */
$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->permanentRedirect('/extensions', '/open-source/packages');
$router->permanentRedirect('/extensions/latest', '/open-source/packages');
$router->permanentRedirect('/extensions/releases', '/open-source/packages');
$router->permanentRedirect('/extensions/updates', '/open-source/updates');

$router->get(
    '/open-source/packages',
    ViewOpenSourcePackagesController::class,
)->name('open-source.packages');

// Package name redirects
$router->permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs', '/open-source/packages/pagerfantabundle/docs');
$router->permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs/{slug}', '/open-source/packages/pagerfantabundle/docs/{slug}');
$router->permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs/{version}/{slug}', '/open-source/packages/pagerfantabundle/docs/{version}/{slug}');

$router->get(
    '/open-source/packages/{package}/docs',
    RedirectToPackageDocsController::class,
)->where('package', '[a-zA-Z0-9-]+');

$router->get(
    '/open-source/packages/{package}/docs/{slug}',
    RedirectToPackageDocsController::class,
)
    ->where('package', '[a-zA-Z0-9-]+')
    ->where('slug', '[a-zA-Z0-9-\/]+')
;

$router->get(
    '/open-source/packages/{package}/docs/{version}/{slug}',
    ViewOpenSourcePackageDocsPageController::class,
)
    ->name('open-source.packages.package-docs-page')
    ->where('package', '[a-zA-Z0-9-]+')
    ->where('slug', '[a-zA-Z0-9-\/]+')
;

$router->get(
    '/open-source/updates/{update}',
    ViewOpenSourceUpdateController::class,
)
    ->name('open-source.update')
    ->where('update', '[a-zA-Z0-9-]+')
;

$router->get(
    '/open-source/updates',
    ViewOpenSourceUpdatesController::class,
)->name('open-source.updates');

$router->get(
    '/open-source/updates/page/{page}',
    ViewOpenSourceUpdatesController::class,
)
    ->name('open-source.updates.paginated')
    ->whereNumber('page');

$router->get(
    '/sponsor',
    ViewSponsorPageController::class,
)->name('sponsor');

$router->get(
    '/sitemap.xml',
    ViewSitemapController::class,
);

$router->feeds('feeds');
