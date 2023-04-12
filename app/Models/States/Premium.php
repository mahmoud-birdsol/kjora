<?php

namespace App\Models\States;

class Premium extends UserPremiumState
{
    /**
     * Get the name of the state
     */
    public function name(): string
    {
        return 'Premium';
    }
}
