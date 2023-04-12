<?php

namespace App\DataTransferObjects;

class Geolocation
{
    private $ip;

    private $country;

    private $region;

    private $city;

    private $latitude;

    private $longitude;

    public function __construct($ip, $country, $region, $city, $latitude, $longitude)
    {
        $this->ip = $ip;
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function ip()
    {
        return $this->ip;
    }

    public function country()
    {
        return $this->country;
    }

    public function region()
    {
        return $this->region;
    }

    public function city()
    {
        return $this->city;
    }

    public function latitude()
    {
        return $this->latitude;
    }

    public function longitude()
    {
        return $this->longitude;
    }
}
