<?php

declare(strict_types=1);

namespace App\Models\Entities;

use DateTime;
use phpDocumentor\Reflection\Location;

/**
 * Due to the fact order word is restricted
 */

class AirportEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var $value
     * Value of the order
     */
     private float $value;

    /**
     * @var airport_from
     * Id of the airport cargo dispatched
     */

    private int $airport_from;

    /**
     * @var airport_to
     * Destination
     */

    private int $airport_to;

    /**
     * @var time_taken
     * Time taken to deliver
     */

    private DateTime $time_taken;

   
    /**
     * Getters and setters
     */
    public function getValue(): string
    {
        return $this->value;
    }
    public function setValue(int $value)
    {
        $this->value = $value;
    }

    public function getAirportFrom(): int
    {
        return $this->airport_from;
    }
    public function setAirportFrom(int $id)
    {
        $this->airport_from = $id;
    }

    public function getAirportTo(): int
    {
        return $this->airport_to;
    }
    public function setAirportTo(int $id)
    {
        $this->airport_to = $id;
    }

    public function getTimeTaken(): DateTime
    {
        return $this->time_taken;
    }
    public function setTimeTaken(DateTime $time_taken)
    {
        $this->time_taken = $time_taken;
    }

}
