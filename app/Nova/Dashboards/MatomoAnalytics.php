<?php

namespace BabDev\Nova\Dashboards;

use BabDev\Matomo\ApiConnector;
use BabDev\Nova\Metrics\BounceRate;
use BabDev\Nova\Metrics\LengthOfVisit;
use BabDev\Nova\Metrics\UniqueVisitorsPerDay;
use BabDev\Nova\Metrics\VisitsPerDay;
use Laravel\Nova\Card;
use Laravel\Nova\Dashboard;

class MatomoAnalytics extends Dashboard
{
    public function label(): string
    {
        return 'Matomo Analytics';
    }

    /**
     * @return list<Card>
     */
    public function cards(): array
    {
        return [
            (new UniqueVisitorsPerDay(app(ApiConnector::class)))->width('1/2'),
            (new VisitsPerDay(app(ApiConnector::class)))->width('1/2'),
            (new LengthOfVisit(app(ApiConnector::class)))->width('1/2'),
            (new BounceRate(app(ApiConnector::class)))->width('1/2'),
        ];
    }

    public function uriKey(): string
    {
        return 'matomo-analytics';
    }
}
