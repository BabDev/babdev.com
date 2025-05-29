<?php

use BabDev\Contracts\Services\Exceptions\PageNotFoundException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: \dirname(__DIR__))
    ->withRouting(
        using: function (): void {
            Route::middleware('web')
                ->domain(config()->string('app.domain'))
                ->group(base_path('routes/web.php'));

            Route::middleware('github.app')
                ->domain(config()->string('app.domain'))
                ->group(base_path('routes/github.php'));
        },
    )
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command(\Spatie\GoogleFonts\Commands\FetchGoogleFontsCommand::class)->weekly();
        $schedule->command(\BabDev\Console\Commands\ImportPackagistDownloads::class)->everyFourHours(24);
        $schedule->command(\BabDev\Console\Commands\ImportGitHubRepositories::class)->dailyAt('12:00');
        $schedule->command(\BabDev\Console\Commands\ImportGitHubSponsorshipTiers::class)->dailyAt('13:00');
        $schedule->command(\BabDev\Console\Commands\ImportGitHubSponsors::class)->dailyAt('13:30');
        $schedule->command(\BabDev\Console\Commands\GenerateSitemap::class)->dailyAt('00:00');
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->group('filament.web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
        ]);

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->group('github.app', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':github.app',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->map(
            PageNotFoundException::class,
            static fn(PageNotFoundException $e): NotFoundHttpException => new NotFoundHttpException($e->getMessage(), $e),
        );
    })->create();
