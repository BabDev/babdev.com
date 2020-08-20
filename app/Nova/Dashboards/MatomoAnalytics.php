<?php

namespace BabDev\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use Rocramer\MatomoAnalytics\Cards\BounceRate;
use Rocramer\MatomoAnalytics\Cards\Downloads;
use Rocramer\MatomoAnalytics\Cards\EntryPages;
use Rocramer\MatomoAnalytics\Cards\ExitPages;
use Rocramer\MatomoAnalytics\Cards\MostViewedPages;
use Rocramer\MatomoAnalytics\Cards\Outlinks;
use Rocramer\MatomoAnalytics\Cards\UniqueVisitors;
use Rocramer\MatomoAnalytics\Cards\VisitLength;
use Rocramer\MatomoAnalytics\Cards\Visits;

class MatomoAnalytics extends Dashboard
{
    public static function label()
    {
        return 'Matomo Analytics';
    }

    public function cards()
    {
        return [
            new UniqueVisitors(),
            new Visits(),
            new VisitLength(),
            new BounceRate(),
            new Outlinks(),
            new Downloads(),
            new EntryPages(),
            new ExitPages(),
            new MostViewedPages(),
        ];
    }

    public static function uriKey()
    {
        return 'matomo-analytics';
    }
}
