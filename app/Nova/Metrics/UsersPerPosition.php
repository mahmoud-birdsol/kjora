<?php

namespace App\Nova\Metrics;

use App\Models\Position;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class UsersPerPosition extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $result = Position::withCount('users')->pluck('users_count', 'name')->toArray();

        return $this->result($result);
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
        return 'users-per-position';
    }
    /**
     * Sey the label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Users Per Position');
    }
}
