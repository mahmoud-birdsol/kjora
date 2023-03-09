<?php

namespace App\Actions\Suspension;

use App\Models\Contracts\Suspendable;

class Activate
{
    /**
     * Mark the specified Model as activated.
     */
    public function __invoke(Suspendable $suspendable): void
    {
        $suspendable->activate();
    }
}
