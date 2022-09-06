<?php

declare(strict_types = 1);

namespace App\Models\Entities;

/**
 * Describes aeroplane used for buildin the fleet
 * You can only have one type of aeroplane but with 
 * different qty (planes)
 */

class AircraftEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var $aircraft_name
     * Aircraft's name
     */
    private string $aircraft_name;

    /**
     * @var $hours_done
     * Hours flown
     */

     private int $hours_done;

    /**
     * @var in_use
     * Is it in use now?
     */

     private int $in_use = 0;

     /**
      * @var airport_base
      * Reference to airport
      */

      private int $airport_base;

      /**
      * @var aeroplane
      * Reference to aeroplane
      */

      private int $aeroplane;


       /**
        * Getters and setters
        */
       

    /**
     * Get the value of aircraft_name
     */
    public function getAircraftName(): string
    {
        return $this->aircraft_name;
    }

    /**
     * Set the value of aircraft_name
     */
    public function setAircraftName(string $aircraftName): self
    {
        $this->aircraft_name = $aircraftName;

        return $this;
    }

     /**
      * Get the value of hours_done
      */
     public function getHoursDone(): int
     {
          return $this->hours_done;
     }

     /**
      * Set the value of hours_done
      */
     public function setHoursDone(int $hoursDone): self
     {
          $this->hours_done = $hoursDone;

          return $this;
     }

     /**
      * Get the value of in_use
      */
     public function getInUse(): int
     {
          return $this->in_use;
     }

     /**
      * Set the value of in_use
      */
     public function setInUse(int $inUse): void
     {
          $this->in_use = $inUse;
     }

      /**
       * Get the value of airport_base
       */
      public function getAirportBase(): int
      {
            return $this->airport_base;
      }

      /**
       * Set the value of airport_base
       */
      public function setAirportBase(int $airportBase): self
      {
            $this->airport_base = $airportBase;

            return $this;
      }

      /**
       * Get the value of aeroplane
       */
      public function getAeroplane(): int
      {
            return $this->aeroplane;
      }

      /**
       * Set the value of aeroplane
       */
      public function setAeroplane(int $aeroplane): self
      {
            $this->aeroplane = $aeroplane;

            return $this;
      }
}