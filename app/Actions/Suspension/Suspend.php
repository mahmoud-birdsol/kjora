<?php

namespace App\Actions\Suspension;

use App\Models\Contracts\Suspendable;

class Suspend
{
    /**
     * Mark the specified model as suspended.
     *
     * @param  \App\Models\Contracts\Suspendable  $suspendable
     * @return void
     */
    public function __invoke(Suspendable $suspendable): void
    {
        $suspendable->suspend();
    }
}
