<?php

namespace App\Models\Contracts;

use Illuminate\Support\Carbon;

interface Publishable
{
    /**
     * Mark the model as published.
     */
    public function publish(?Carbon $date = null): void;

    /**
     * Mark the model as unpublished.
     */
    public function unPublish(): void;
}
