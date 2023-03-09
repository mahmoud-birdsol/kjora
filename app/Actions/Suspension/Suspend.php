<?php

namespace App\Actions\Suspension;

use App\Models\Contracts\Suspendable;

class Suspend
{
    /**
     * Mark the specified model as suspended.
     */
    public function __invoke(Suspendable $suspendable): void
    {
        $suspendable->suspend();
    }
}
