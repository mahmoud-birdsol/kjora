<?php

namespace App\Actions\Suspension;

use Illuminate\Database\Eloquent\Model;

class Suspend
{
    /**
     * Mark the specified model as suspended.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $suspendable
     * @return void
     */
    public function __invoke(Model $suspendable): void
    {
        $suspendable->suspend();
    }
}
