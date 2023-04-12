<?php

namespace App\Services\Geolocator;

use App\Contracts\GeolocatorInterface;
use App\DataTransferObjects\Geolocation;

class IpInfo implements GeolocatorInterface
{
    public static function locate($ip): Geolocation
    {
        $geoLocatorApi = new GeolocatorApiAdapter(new IPGeolocationApi($ip));
        $details = $geoLocatorApi->getDetails();

        return new Geolocation($details['query'], $details['country'], $details['region'], $details['city'], $details['lat'], $details['lon']);
    }
}
