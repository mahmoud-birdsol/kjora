<?php

namespace App\Services\Geolocator;

use Illuminate\Support\Facades\Http;

class IPGeolocationApi implements GeoLocatorApiInterface
{
    private $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function getDetails()
    {
        $ipInfo = Http::get(config('services.ip_api_geolocation_url').$this->ip);

        return $ipInfo->json($key = null);
    }
}
