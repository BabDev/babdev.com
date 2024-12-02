<?php

use BabDev\Http\Controllers\HandleGitHubAppWebhookController;
use Illuminate\Support\Facades\Route;

Route::post(
    '/webhooks/github/app',
    HandleGitHubAppWebhookController::class,
);
