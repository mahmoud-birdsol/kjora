<?php

namespace App\Actions\Publishable;

use App\Models\Contracts\Publishable;

class UnPublish
{
    /**
     * Mark the specified model as unpublished.
     *
     * @param  \App\Models\Contracts\Publishable  $publishable
     * @return void
     */
    public function __invoke(Publishable $publishable): void
    {
        $publishable->unPublish();
    }
}
