<?php

namespace BabDev\Listeners;

use BabDev\Breadcrumbs\Events\AfterBreadcrumbGenerated;

final class AppendPageNumberToBreadcrumbs
{
    private const array SUPPORTED_BREADCRUMBS = [
        'open-source.updates',
    ];

    public function handle(AfterBreadcrumbGenerated $event): void
    {
        if (!\in_array($event->name, self::SUPPORTED_BREADCRUMBS, true)) {
            return;
        }

        $page = request('page', '1');

        if (is_numeric($page) && ((int) $page > 1)) {
            $event->breadcrumbs->push("Page $page", null, ['current' => false]);
        }
    }
}
