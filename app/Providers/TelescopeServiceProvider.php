<?php

namespace BabDev\Providers;

use Laravel\Telescope\TelescopeApplicationServiceProvider;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Override the Telescope authorization service to only apply the default env check.
     */
    #[\Override]
    protected function authorization(): void
    {
        // no-op to disable the gate and the overridden auth check
    }
}
