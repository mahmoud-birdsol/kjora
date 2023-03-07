<?php

namespace App\Actions\Verification;

class GenerateRandomCodeNumber
{
    /**
     * Generates a random code
     *
     * @return int
     * @throws \Exception
     */
    public function __invoke(): int
    {
        return random_int(1000, 9999);
    }
}
