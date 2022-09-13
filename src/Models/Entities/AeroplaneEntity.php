<?php

declare(strict_types = 1);

namespace App\Models\Entities;

/**
 * Describes aeroplane used for buildin the fleet
 * You can only have one type of aeroplane but with 
 * different qty (planes)
 */

class AeroplaneEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var $vendor
     * Manufacturer of the plane
     */
    private string $vendor;

    /**
     * @var photo
     * Photo of the plane, simply path to the file
     */

     private string $photo ='';

    /**
     * @var model
     * Model (type) of the plane
     */

     private string $model;

     /**
      * @var payload
      * Capacity of the plane
      */

      private int $payload;

        /**
      * @var distance
      * Capacity of the plane
      */

      private int $distance;

       /**
        * Getters and setters
        */
       public function getVendor(): string
       {
        return $this->vendor;
       }

       public function setVendor(string $vendor)
       {
        $this->vendor = $vendor;
       }

       public function getPhoto(): ?string
       {
        return $this->photo;
       }

       public function setPhoto(string $photo)
       {
        $this->photo = $photo;
       }

       public function getModel(): string
       {
        return $this->model;
       }

       public function setModel(string $model)
       {
        $this->model = $model;
       }
       public function getPayload(): int
       {
        return $this->payload;
       }

       public function setPayload(int $payload)
       {
        $this->payload = $payload;
       }
       public function getDistance(): int
       {
        return $this->distance;
       }

       public function setDistance(int $distance)
       {
        $this->distance = $distance;
       }
}