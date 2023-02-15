<?php

namespace BabDev\Console;

use BabDev\Console\Commands\GenerateSitemap;
use BabDev\Console\Commands\ImportGitHubRepositories;
use BabDev\Console\Commands\ImportGitHubSponsors;
use BabDev\Console\Commands\ImportGitHubSponsorshipTiers;
use BabDev\Console\Commands\ImportPackagistDownloads;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\GoogleFonts\Commands\FetchGoogleFontsCommand;

final class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(FetchGoogleFontsCommand::class)->weekly();
        $schedule->command(ImportPackagistDownloads::class)->hourly();
        $schedule->command(ImportGitHubRepositories::class)->dailyAt('12:00');
        $schedule->command(ImportGitHubSponsorshipTiers::class)->dailyAt('13:00');
        $schedule->command(ImportGitHubSponsors::class)->dailyAt('13:30');
        $schedule->command(GenerateSitemap::class)->dailyAt('00:00');
    }
}
