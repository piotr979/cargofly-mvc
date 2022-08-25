<?php

declare(strict_types = 1 );

namespace App\Helpers;

class MapLocation {

    private float $lat;
    private float $lon;

    public function __construct(float $lat, float $lon)
    {
       $this->setLocation($lat, $lon);
    }
    public function setLocation(float $lat, float $lon)
    {
        $this->setLat($lat);
        $this->setLon($lon);
    }
    public function setLat(float $lat)
    {
        $this->lat = $lat;
    }
    public function setLon(float $lon)
    {
        $this->lon = $lon;
    }
    public function getLat(): float
    {
        return $this->lat;
    }
    public function getLon(): float
    {
        return $this->lon;
    }
}