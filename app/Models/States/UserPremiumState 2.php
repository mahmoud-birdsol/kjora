<?php

namespace App\Models\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserPremiumState extends State
{
    /**
     * Get the name of the state
     */
    abstract public function name(): string;

    /**
     * Configure the default states and the transitions of the class
     *
     * @throws \Spatie\ModelStates\Exceptions\InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Free::class)
            ->allowTransition(Free::class, Premium::class)
            ->allowTransition(Premium::class, Free::class);
    }
}
