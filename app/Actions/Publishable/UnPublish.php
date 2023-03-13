<?php

namespace App\Actions\Publishable;

use App\Models\Contracts\Publishable;

class UnPublish
{
    /**
     * Mark the specified model as unpublished.
     */
    public function __invoke(Publishable $publishable): void
    {
        $publishable->unPublish();
    }
}
