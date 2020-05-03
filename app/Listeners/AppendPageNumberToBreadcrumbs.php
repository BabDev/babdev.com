<?php

namespace BabDev\Listeners;

use BabDev\Breadcrumbs\Events\AfterBreadcrumbGenerated;

class AppendPageNumberToBreadcrumbs
{
    private const SUPPORTED_BREADCRUMBS = [
        'open-source.updates',
    ];

    public function handle(AfterBreadcrumbGenerated $event): void
    {
        if (!\in_array($event->name, self::SUPPORTED_BREADCRUMBS, true)) {
            return;
        }

        $page = (int) request('page', 1);

        if ($page > 1) {
            $event->breadcrumbs->push("Page $page", null, ['current' => false]);
        }
    }
}
