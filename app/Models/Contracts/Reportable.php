<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Reportable
{
    /**
     * Get the reportable object reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reports(): MorphMany;
}
