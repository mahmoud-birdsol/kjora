<?php

namespace App\Models\Contracts;

use App\Models\User;

interface Likeable
{
    public function owner(): User|null;

    public function url(): string;
}
