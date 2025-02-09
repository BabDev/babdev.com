<?php

namespace BabDev\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    #[\Override]
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
