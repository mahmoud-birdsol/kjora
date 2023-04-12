<?php

namespace App\Actions\Publishable;

use App\Models\Contracts\Publishable;

class Publish
{
    /**
     * Mark the publishable as published on the specified date.
     */
    public function __invoke(Publishable $publishable, $date = null): void
    {
        $publishable->publish($date);
    }
}
