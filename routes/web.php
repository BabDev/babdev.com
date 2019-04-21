<?php

/** @var \Illuminate\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->view('/', 'homepage')->name('homepage');
$router->view('/privacy', 'privacy')->name('privacy');

$router->get('/joomla-extensions', 'JoomlaExtensionsController@index')->name('joomla-extensions.index');
