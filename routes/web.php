<?php

use BabDev\Http\Controllers\DownloadReleaseFileController;
use BabDev\Http\Controllers\UploadImageThruCKEditorController;
use BabDev\Http\Controllers\ViewOpenSourcePackagesController;
use BabDev\Http\Controllers\ViewOpenSourcePackageReleaseController;
use BabDev\Http\Controllers\ViewOpenSourcePackageReleasesController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->get(
    '/download/{media:file_name}',
    DownloadReleaseFileController::class
)->name('download-release-file');

$router->get(
    '/open-source/packages',
    ViewOpenSourcePackagesController::class
)->name('open-source.packages');

$router->get(
    '/open-source/packages/{package}/releases',
    ViewOpenSourcePackageReleasesController::class
)->name('open-source.package.releases');

$router->get(
    '/open-source/packages/{package}/releases/{package_release}',
    ViewOpenSourcePackageReleaseController::class
)->name('open-source.package.release');

$router->group(
    [
        'middleware' => ['auth'],
    ],
    static function (Router $router): void {
        $router->post(
            '/ckeditor/upload/image',
            UploadImageThruCKEditorController::class
        )->name('ckeditor.upload.image');
    }
);
