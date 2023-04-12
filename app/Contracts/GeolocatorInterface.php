<?php

namespace App\Contracts;

interface GeolocatorInterface
{
    public static function locate(string $ip);
}
