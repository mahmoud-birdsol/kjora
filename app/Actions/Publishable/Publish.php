<?php

namespace App\Actions\Publishable;

use App\Models\Contracts\Publishable;
use Illuminate\Support\Carbon;

class Publish
{
    /**
     * Mark the publishable as published on the specified date.
     */
    public function __invoke(Publishable $publishable, ?Carbon $date = null): void
    {
        $publishable->publish($date);
    }
}
