<?php

use App\Http\Controllers\RedirectToPackageDocsController;
use App\Http\Controllers\ViewOpenSourcePackageDocsPageController;
use App\Http\Controllers\ViewOpenSourcePackagesController;
use App\Http\Controllers\ViewOpenSourceUpdateController;
use App\Http\Controllers\ViewOpenSourceUpdatesController;
use App\Http\Controllers\ViewSitemapController;
use Illuminate\Support\Facades\Route;

Route::domain(config()->string('app.domain'))->group(function () {
    Route::view('/', 'homepage')->name('homepage');
    Route::view('/privacy', 'privacy')->name('privacy');

    Route::permanentRedirect('/extensions', '/open-source/packages');
    Route::permanentRedirect('/extensions/latest', '/open-source/packages');
    Route::permanentRedirect('/extensions/releases', '/open-source/packages');
    Route::permanentRedirect('/extensions/updates', '/open-source/updates');
    Route::redirect('/sponsor', '/');

    Route::get(
        '/open-source/packages',
        ViewOpenSourcePackagesController::class,
    )->name('open-source.packages');

    // Package name redirects
    Route::permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs', '/open-source/packages/pagerfantabundle/docs');
    Route::permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs/{slug}', '/open-source/packages/pagerfantabundle/docs/{slug}');
    Route::permanentRedirect('/open-source/packages/babdevpagerfantabundle/docs/{version}/{slug}', '/open-source/packages/pagerfantabundle/docs/{version}/{slug}');

    Route::get(
        '/open-source/packages/{package}/docs',
        RedirectToPackageDocsController::class,
    )->where('package', '[a-zA-Z0-9-]+');

    Route::get(
        '/open-source/packages/{package}/docs/{slug}',
        RedirectToPackageDocsController::class,
    )
        ->where('package', '[a-zA-Z0-9-]+')
        ->where('slug', '[a-zA-Z0-9-\/]+')
    ;

    Route::get(
        '/open-source/packages/{package}/docs/{version}/{slug}',
        ViewOpenSourcePackageDocsPageController::class,
    )
        ->name('open-source.packages.package-docs-page')
        ->where('package', '[a-zA-Z0-9-]+')
        ->where('slug', '[a-zA-Z0-9-\/]+')
    ;

    Route::get(
        '/open-source/updates/{update}',
        ViewOpenSourceUpdateController::class,
    )
        ->name('open-source.update')
        ->where('update', '[a-zA-Z0-9-]+')
    ;

    Route::get(
        '/open-source/updates',
        ViewOpenSourceUpdatesController::class,
    )->name('open-source.updates');

    Route::get(
        '/open-source/updates/page/{page}',
        ViewOpenSourceUpdatesController::class,
    )
        ->name('open-source.updates.paginated')
        ->whereNumber('page');

    Route::get(
        '/sitemap.xml',
        ViewSitemapController::class,
    );

    Route::feeds('feeds');
});
