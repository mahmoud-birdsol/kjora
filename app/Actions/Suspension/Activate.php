<?php

namespace App\Actions\Suspension;

use App\Models\Contracts\Suspendable;

class Activate
{
    /**
     * Mark the specified Model as activated.
     *
     * @param  \App\Models\Contracts\Suspendable  $suspendable
     * @return void
     */
    public function __invoke(Suspendable $suspendable): void
    {
        $suspendable->activate();
    }
}
