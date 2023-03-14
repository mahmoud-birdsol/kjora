<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class VerifiedVsUnverifiedUsers extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result([
            'Verified' => User::whereNotNull('identity_verified_at')->count(),
            'Unverified' => User::whereNull('identity_verified_at')->count(),
        ])->colors([
            'Verified' => '#059669',
            'Unverified' => '#e11d48',
        ]);
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
        return 'verified-vs-unverified-users';
    }
    /**
     * Sey the label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Verified Vs Unverified Users');
    }
}
