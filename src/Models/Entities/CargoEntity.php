<?php

declare(strict_types=1);

namespace App\Models\Entities;

use DateTime;
use DeliveryStatus;

/**
 * Due to the fact order word is restricted
 */

class CargoEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var customer_id
     * Id of the airport cargo dispatched
     */

    private int $customer_id;

     /**
     * @var value
     * Order's value
     */

    private int $value;

    /**
     * @var airport_from
     * Id of the airport cargo dispatched
     */

    private int $city_from;

    /**
     * @var airport_to
     * Destination
     */

    private int $city_to;

     /**
     * @var status
     * Status of the delivery 
     * 0 = not picked up, 
     * 1 = on delivery, 
     * 2 = delivered
     */

    private int $status;

    /**
     * @var time_taken
     * Time taken to deliver (in hours)
     */

    private int $time_taken = -1;

    /**
     * @var weight
     * Weight in tonnes
     */

    private int $weight;

    /**
     * @var size
     * Total size (w*d*h)
     */

    private int $size;

    /**
     * Getters and setters
     */

    public function getCityFrom(): int
    {
        return $this->city_from;
    }
    public function setCityFrom(int $id)
    {
        $this->city_from = $id;
    }

    public function getCityTo(): int
    {
        return $this->city_to;
    }
    public function setCityTo(int $id)
    {
        $this->city_to = $id;
    }

    public function getCustomer(): int
    {
        return $this->customer_id;
    }
    public function setCustomer(int $customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function getTimeTaken(): int
    {
        return $this->time_taken;
    }
    public function setTimeTaken(int $time_taken)
    {
        $this->time_taken = $time_taken;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }
    public function getSize(): int
    {
        return $this->size;
    }
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    public function getValue(): int
    {
        return $this->value;
    }
    public function setValue(int $value)
    {
        $this->value = $value;
    }
    
    public function getStatus(): int
    {
        return $this->status;
    }
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

}
