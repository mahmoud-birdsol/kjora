<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Reportable
{
    /**
     * Get the reportable object reports.
     */
    public function reports(): MorphMany;
}
