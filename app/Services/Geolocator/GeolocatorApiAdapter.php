<?php

namespace App\Services\Geolocator;

class GeolocatorApiAdapter
{
    private GeoLocatorApiInterface $geoLocatorApi;

    public function __construct(GeoLocatorApiInterface $geoLocatorApi)
    {
        $this->geoLocatorApi = $geoLocatorApi;
    }

       public function getDetails()
       {
           return $this->geoLocatorApi->getDetails();
       }
}
