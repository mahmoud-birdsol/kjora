<?php

namespace App\Models\States;

class Free extends UserPremiumState
{

    /**
     * Get the name of the state
     *
     * @return string
     */
    public function name(): string
    {
        return 'Free';
    }
}
