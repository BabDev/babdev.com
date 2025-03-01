<?php

use Illuminate\Support\Facades\Schedule;
use Spatie\GoogleFonts\Commands\FetchGoogleFontsCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use BabDev\Console\Commands\ImportPackagistDownloads;
use BabDev\Console\Commands\ImportGitHubSponsorshipTiers;
use BabDev\Console\Commands\ImportGitHubSponsors;
use BabDev\Console\Commands\ImportGitHubRepositories;
use BabDev\Console\Commands\GenerateSitemap;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command(FetchGoogleFontsCommand::class)->weekly();
Schedule::command(ImportPackagistDownloads::class)->hourly();
Schedule::command(ImportGitHubRepositories::class)->dailyAt('12:00');
Schedule::command(ImportGitHubSponsorshipTiers::class)->dailyAt('13:00');
Schedule::command(ImportGitHubSponsors::class)->dailyAt('13:30');
Schedule::command(GenerateSitemap::class)->dailyAt('00:00');
