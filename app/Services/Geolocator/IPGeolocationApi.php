<?php

namespace App\Services\Geolocator;

use Illuminate\Support\Facades\Http;

class IPGeolocationApi implements GeoLocatorApiInterface
{
    private  $ip;
    public function __construct($ip)
    {
        $this->ip = $ip;
    }
    public  function getDetails()
    {
        $ipInfo = Http::get("http://ip-api.com/json/{$this->ip}");
        return $ipInfo->json($key = null);

    }
}
