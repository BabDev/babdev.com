<?php

namespace BabDev\Nova\Metrics;

use BabDev\Matomo\ApiConnector;
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

    public function calculate(NovaRequest $request): TrendResult
    {
        $visitsLength = $this->connector->visitsSummary('getSumVisitsLength', (int) $request->input('range'));
        $visits = $this->connector->visitsSummary('getVisits', (int) $request->input('range'));

        $results = [];

        foreach (array_keys($visitsLength) as $key) {
            if ($visits[$key]) {
                $results[$key] = (int) round($visitsLength[$key] / $visits[$key]);
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
            7 => trans('7 Days'),
            14 => trans('14 Days'),
            30 => trans('30 Days'),
            90 => trans('90 Days'),
        ];
    }

    public function cacheFor()
    {
        if ($cacheMinutes = config('services.matomo.caching', 5)) {
            return now()->addMinutes($cacheMinutes);
        }

        return parent::cacheFor();
    }

    public function uriKey(): string
    {
        return 'length-of-visit';
    }
}
