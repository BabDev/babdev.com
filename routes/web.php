<?php

use BabDev\Http\Controllers\JoomlaExtensionsController;
use Illuminate\Routing\Router;

/** @var Router $router */

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->get('/joomla-extensions', [JoomlaExtensionsController::class, 'index'])->name('joomla-extensions.index');
