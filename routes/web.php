<?php

use BabDev\Http\Controllers\RedirectToPackageDocsController;
use BabDev\Http\Controllers\UploadImageThruCKEditorController;
use BabDev\Http\Controllers\ViewOpenSourcePackageDocsPageController;
use BabDev\Http\Controllers\ViewOpenSourcePackagesController;
use BabDev\Http\Controllers\ViewOpenSourceUpdateController;
use BabDev\Http\Controllers\ViewOpenSourceUpdatesController;
use BabDev\Http\Controllers\ViewSitemapController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');
$router->view('/sponsor', 'sponsor')->name('sponsor');

$router->permanentRedirect('/extensions', '/open-source/packages');
$router->permanentRedirect('/extensions/latest', '/open-source/packages');
$router->permanentRedirect('/extensions/releases', '/open-source/packages');
$router->permanentRedirect('/extensions/updates', '/open-source/updates');

$router->get(
    '/open-source/packages',
    ViewOpenSourcePackagesController::class
)->name('open-source.packages');

$router->get(
    '/open-source/packages/{package}/docs',
    RedirectToPackageDocsController::class
);

$router->get(
    '/open-source/packages/{package}/docs/{slug}',
    RedirectToPackageDocsController::class
);

$router->get(
    '/open-source/packages/{package}/docs/{version}/{slug}',
    ViewOpenSourcePackageDocsPageController::class
)->name('open-source.packages.package-docs-page');

$router->get(
    '/open-source/updates/{update}',
    ViewOpenSourceUpdateController::class
)->name('open-source.update');

$router->get(
    '/open-source/updates',
    ViewOpenSourceUpdatesController::class
)->name('open-source.updates');

$router->get(
    '/open-source/updates/page/{page}',
    ViewOpenSourceUpdatesController::class
)->name('open-source.updates.paginated');

$router->get(
    '/sitemap.xml',
    ViewSitemapController::class
);

$router->group(
    [
        'middleware' => ['auth'],
    ],
    static function (Router $router): void {
        $router->domain(config('nova.domain', null))
            ->post(
                '/ckeditor/upload/image',
                UploadImageThruCKEditorController::class
            )->name('ckeditor.upload.image');
    }
);
