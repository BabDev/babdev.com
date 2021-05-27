<?php

namespace BabDev\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('import:packagist-downloads')->hourly();
        $schedule->command('import:github-repositories')->dailyAt('12:00');
        $schedule->command('import:github-sponsorship-tiers')->dailyAt('13:00');
        $schedule->command('sitemap:generate')->dailyAt('00:00');
    }
}
