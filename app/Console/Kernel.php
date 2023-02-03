<?php

namespace BabDev\Console;

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
        $schedule->command(Commands\ImportPackagistDownloads::class)->hourly();
        $schedule->command(Commands\ImportGitHubRepositories::class)->dailyAt('12:00');
        $schedule->command(Commands\ImportGitHubSponsorshipTiers::class)->dailyAt('13:00');
        $schedule->command(Commands\ImportGitHubSponsors::class)->dailyAt('13:30');
        $schedule->command(Commands\GenerateSitemap::class)->dailyAt('00:00');
    }
}
