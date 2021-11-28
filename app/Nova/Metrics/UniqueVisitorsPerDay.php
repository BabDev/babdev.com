<?php

namespace BabDev\Nova\Metrics;

use BabDev\Matomo\ApiConnector;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class UniqueVisitorsPerDay extends Trend
{
    public function __construct(private ApiConnector $connector)
    {
        parent::__construct();
    }

    public function calculate(NovaRequest $request): TrendResult
    {
        $results = $this->connector->visitsSummary('getUniqueVisitors', (int) $request->input('range'));

        return (new TrendResult())
            ->trend($results)
            ->showLatestValue();
    }

    /**
     * @return array<int, string>
     */
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
        return 'unique-visitors-per-day';
    }
}
