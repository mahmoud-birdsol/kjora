<?php

namespace App\Nova\Metrics;

use App\Models\Advertisement;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class ExpiringAdvertisementTable extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return Advertisement::expiring()
            ->get()
            ->map(function (Advertisement $advertisement) {
                return MetricTableRow::make()
                    ->icon('exclamation-circle')
                    ->iconClass('text-amber-500')
                    ->title($advertisement->name)
                    ->subtitle('Expiring  on '.$advertisement->end_date->toFormattedDateString())
                    ->actions(function () use ($advertisement) {
                        return [
                            MenuItem::link('View', '/resources/advertisements/'.$advertisement->id),
                        ];
                    });
            });
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
}
