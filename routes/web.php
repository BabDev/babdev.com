<?php

use BabDev\Http\Controllers\JoomlaExtensionReleasesController;
use BabDev\Http\Controllers\JoomlaExtensionsController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->get(
    '/joomla-extensions',
    [JoomlaExtensionsController::class, 'index']
)->name('joomla-extensions.index');

$router->get(
    '/joomla-extensions/{joomla_extension}/releases',
    [JoomlaExtensionReleasesController::class, 'index']
)->name('joomla-extensions.releases.index');

$router->get(
    '/joomla-extensions/{joomla_extension}/release/{joomla_extension_release}',
    [JoomlaExtensionReleasesController::class, 'show']
)->name('joomla-extensions.releases.show');
