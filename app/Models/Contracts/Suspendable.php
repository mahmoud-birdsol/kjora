<?php

namespace App\Models\Contracts;

interface Suspendable
{
    /**
     * Suspend the model.
     *
     * @return void
     */
    public function suspend(): void;

    /**
     * Activate the model.
     *
     * @return void
     */
    public function activate(): void;
}
