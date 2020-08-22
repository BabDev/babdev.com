<?php

namespace BabDev\Nova\Dashboards;

use BabDev\Matomo\ApiConnector;
use BabDev\Nova\Metrics\BounceRate;
use BabDev\Nova\Metrics\LengthOfVisit;
use BabDev\Nova\Metrics\UniqueVisitorsPerDay;
use BabDev\Nova\Metrics\VisitsPerDay;
use Laravel\Nova\Dashboard;
use Rocramer\MatomoAnalytics\Cards\EntryPages;
use Rocramer\MatomoAnalytics\Cards\ExitPages;
use Rocramer\MatomoAnalytics\Cards\MostViewedPages;

class MatomoAnalytics extends Dashboard
{
    public static function label()
    {
        return 'Matomo Analytics';
    }

    public function cards()
    {
        return [
            (new UniqueVisitorsPerDay(app(ApiConnector::class)))->width('1/2'),
            (new VisitsPerDay(app(ApiConnector::class)))->width('1/2'),
            (new LengthOfVisit(app(ApiConnector::class)))->width('1/2'),
            (new BounceRate(app(ApiConnector::class)))->width('1/2'),
            new MostViewedPages(),
        ];
    }

    public static function uriKey()
    {
        return 'matomo-analytics';
    }
}
