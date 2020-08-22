<?php

namespace BabDev\Nova\Metrics;

use BabDev\Matomo\ApiConnector;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class LengthOfVisit extends Trend
{
    private ApiConnector $connector;

    public function __construct(ApiConnector $connector)
    {
        $this->connector = $connector;

        parent::__construct();
    }

    public function calculate(NovaRequest $request)
    {
        $visitsLength = $this->connector->visitsSummary('getSumVisitsLength', (int) $request->range);
        $visits = $this->connector->visitsSummary('getVisits', (int) $request->range);

        $results = [];

        foreach (\array_keys($visitsLength) as $key) {
            if ($visits[$key]) {
                $results[$key] = (int) \round($visitsLength[$key] / $visits[$key]);
            } else {
                $results[$key] = 0;
            }
        }

        return (new TrendResult())
            ->trend($results)
            ->showLatestValue()
            ->suffix('seconds (avg.)')
            ->withoutSuffixInflection();
    }

    public function ranges(): array
    {
        return [
            7 => __('7 Days'),
            14 => __('14 Days'),
            30 => __('30 Days'),
            90 => __('90 Days'),
        ];
    }

    public function cacheFor()
    {
        if ($cacheMinutes = config('services.matomo.caching', 5)) {
            return Carbon::now()->addMinutes($cacheMinutes);
        }

        return parent::cacheFor();
    }

    public function uriKey(): string
    {
        return 'length-of-visit';
    }
}
