<?php

declare(strict_types=1);

namespace App\Models\Entities;

use App\Helpers\MapLocation;
use phpDocumentor\Reflection\Location;

/**
 * Describes airport.
 */

class CustomerEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @var $customer_name
     * Company name
     */
    private ?string $customer_name;

    /**
     * @var $owner_fname
     * First name of the owner
     */

    private string $owner_fname;

   /**
     * @var $owner_lname
     * Last name of the owner
     */

    private string $owner_lname;

   /**
     * @var $street1
     * Street address 1
     */

    private string $street1;

    /**
     * @var $street2
     * Street address 2 (not mandatory)
     */

    private string $street2 = '';

     /**
     * @var $city
     * City name
     */

    private string $city;
    
    /**
     * @var zip_code
     * Zip code
     */

    private string $zip_code;

     /**
     * @var country
     * Country
     */

    private string $country;

     /**
     * @var vat
     * Country
     */

    private int $vat;

     /**
     * @var logo
     * Logo
     */

    private string $logo = '';

    public function __construct()
    {
    }
    /**
     * Getters and setters
     */
    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customerName)
    {
        $this->customer_name = $customerName;
    }
    public function getOwnerFName(): string
    {
        return $this->owner_fname;
    }

    public function setOwnerFName(string $owner_fname)
    {
        $this->owner_fname = $owner_fname;
    }
    public function getOwnerLName(): string
    {
        return $this->owner_lname;
    }

    public function setOwnerLName(string $owner_lname)
    {
        $this->owner_lname = $owner_lname;
    }

    public function getStreet1(): string
    {
        return $this->street1;
    }
    public function setStreet1(string $street1)
    {
        $this->street1 = $street1;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }
    public function setStreet2(string $street2)
    {
        $this->street2 = $street2;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }
    public function setZipCode(string $zipCode)
    {
        $this->zip_code = $zipCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function getVat(): int
    {
        return $this->vat;
    }
    public function setVat(int $vat)
    {
        $this->vat = $vat;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }
    public function setLogo(string $logo)
    {
        $this->logo = $logo;
    }

}
