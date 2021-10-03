<?php

use BabDev\Http\Controllers\HandleGitHubAppWebhookController;
use Illuminate\Routing\Router;

/** @var Router $router */
$router->post(
    '/webhooks/github/app',
    HandleGitHubAppWebhookController::class,
);
