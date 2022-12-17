<?php

namespace App\Actions\Suspension;

use Illuminate\Database\Eloquent\Model;

class Activate
{
    /**
     * Mark the specified Model as activated.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $suspendable
     * @return void
     */
    public function __invoke(Model $suspendable): void
    {
        $suspendable->activate();
    }
}
