<?php

namespace App\Nova\Metrics;

use App\Models\Admin;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class PendingInvitations extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        Admin::whereNull('joined_platform_at')
            ->get()
            ->map(function (Admin $admin) {
                return MetricTableRow::make()
                    ->icon('exclamation-circle')
                    ->iconClass('text-yellow-500')
                    ->title($admin->name)
                    ->subtitle('Was created on '.$admin->created_at->toDateTimeString())
                    ->actions(function () use ($admin) {
                        return [
                            MenuItem::link('View', '/resources/admins/'.$admin->id),
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
        // return now()->addMinutes(5);
    }
}
