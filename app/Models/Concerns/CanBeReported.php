<?php

namespace App\Models\Concerns;

use App\Models\Report;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanBeReported
{
    /**
     * Get the reportable model reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
