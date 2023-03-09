<?php

namespace App\Models\Contracts;

interface Suspendable
{
    /**
     * Suspend the model.
     */
    public function suspend(): void;

    /**
     * Activate the model.
     */
    public function activate(): void;
}
