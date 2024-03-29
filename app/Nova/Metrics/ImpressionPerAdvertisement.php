<?php

namespace App\Nova\Metrics;

use App\Models\Impression;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ImpressionPerAdvertisement extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Impression::query()->join('advertisements', 'impressions.advertisement_id', '=', 'advertisements.id'),
            'advertisements.name'
        );
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'impression-per-advertisement';
    }

    public function name()
    {
        return __('Impression Per Advertisement');
    }
}
