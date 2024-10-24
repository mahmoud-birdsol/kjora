<?php

namespace App\Nova\Metrics;

use App\Models\Click;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ClickPerAdvertisement extends Partition
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
            Click::query()->join('advertisements', 'clicks.advertisement_id', '=', 'advertisements.id'),
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
        return 'click-per-advertisement';
    }

    /**
     * Sey the label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Click Per Advertisement');
    }
}
