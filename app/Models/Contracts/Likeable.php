<?php

namespace App\Models\Contracts;

use App\Models\User;

interface Likeable
{
    public function owner(): User;

    public function url(): string;
}
