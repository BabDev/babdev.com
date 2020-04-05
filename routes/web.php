<?php

use BabDev\Http\Controllers\CKEditorUploadController;
use BabDev\Http\Controllers\OpenSourceController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->get(
    '/open-source/download/{media}',
    [OpenSourceController::class, 'downloadReleaseFile']
)->name('open-source.download-release-file');

$router->get(
    '/open-source/packages',
    [OpenSourceController::class, 'packages']
)->name('open-source.packages');

$router->get(
    '/open-source/packages/{package}/releases',
    [OpenSourceController::class, 'packageReleases']
)->name('open-source.package.releases');

$router->get(
    '/open-source/packages/{package}/releases/{package_release}',
    [OpenSourceController::class, 'packageRelease']
)->name('open-source.package.release');

$router->group(
    [
        'middleware' => ['auth'],
    ],
    static function (Router $router): void {
        $router->post(
            '/ckeditor/upload/image',
            [CKEditorUploadController::class, 'uploadImage']
        )->name('ckeditor.upload.image');
    }
);
