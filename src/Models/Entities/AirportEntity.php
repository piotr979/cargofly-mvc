<?php

declare(strict_types=1);

namespace App\Models\Entities;

use App\Helpers\MapLocation;
use phpDocumentor\Reflection\Location;

/**
 * Describes airport.
 */

class AirportEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var $code
     * Three letters code of airport
     */
    private string $code;

    /**
     * @var airportName
     * Name of the airport
     */

    private string $airport_name = '';

    /**
     * @var city
     * City where the airport is placed
     */

    private string $city;

    /**
     * @var country
     * Country of the airport
     */

    private string $country;

    /**
     * @var location
     * Location is stored as string but is binary data
     * Contains lat and lon and needs to be unpacked
     * (in getLocation method )
     */

    private string $location;


    /**
     * @var elevation
     */

    private int $elevation;

    public function __construct()
    {
     //   $this->location = new MapLocation(0, 0);
    }
    /**
     * Getters and setters
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function getAirportName(): ?string
    {
        return $this->airport_name;
    }

    public function setAirportName(string $airportName)
    {
        $this->airport_name = $airportName;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
    }
    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(int $country)
    {
        $this->country = $country;
    }

    public function getLocation(): array
    {
        return unpack('x/x/x/x/corder/Ltype/dlat/dlon', $this->location);
    }

    public function getElevation(): int
    {
        return $this->elevation;
    }

    public function setElevation(int $elevation)
    {
        $this->elevation = $elevation;
    }

}
