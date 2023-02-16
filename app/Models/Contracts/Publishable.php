<?php

namespace App\Models\Contracts;

use Illuminate\Support\Carbon;

interface Publishable
{
    /**
     * Mark the model as published.
     *
     * @param  \Illuminate\Support\Carbon|null  $date
     * @return void
     */
    public function publish(?Carbon $date = null): void;

    /**
     * Mark the model as unpublished.
     *
     * @return void
     */
    public function unPublish(): void;
}
