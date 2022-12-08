<?php

namespace App\Models\Queries;

use Illuminate\Database\Eloquent\Builder;

class AdvertisementQueryBuilder extends Builder
{
    /**
     * Filter to active advertisements.
     *
     * @return \App\Models\Queries\AdvertisementQueryBuilder
     */
    public function active(): AdvertisementQueryBuilder
    {
        return $this
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>', now());
    }

    /**
     * Filter to expiring advertisements.
     *
     * @return \App\Models\Queries\AdvertisementQueryBuilder
     */
    public function expiring(): AdvertisementQueryBuilder
    {
        $threshold = now()->addDays(config('advertisements.expiring_threshold'));

        return $this->whereDate('end_date', '<', $threshold);
    }

    /**
     * Filter to active advertisements.
     *
     * @return \App\Models\Queries\AdvertisementQueryBuilder
     */
    public function archived(): AdvertisementQueryBuilder
    {
        return $this->whereDate('end_date', '<', now());
    }
}
