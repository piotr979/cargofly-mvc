<?php

declare(strict_types = 1);

namespace App\Forms;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AirportRepository;
use App\Models\Repositories\CustomerRepository;
use PDO;
class AbstractForm
{
    public function __construct()
    {

    }

    protected function getAllCustomersNames(): array
    {
        $customersRepo = new CustomerRepository();
        $customers = $customersRepo->getAll(PDO::FETCH_CLASS);
        if (empty($customers)) {
            return [];
        }
        foreach ($customers as $customer) {
            $selectCustomers[$customer->getId()] = 
                            $customer->getCustomerName()
                        ;
        }
        return $selectCustomers;
    }
      /**
     * This function fetches all available plane models from database
     */
    protected function getAeroplaneModels(): array
    {
        $planesRepo = new AeroplaneRepository();
        $planes = $planesRepo->getAll(PDO::FETCH_CLASS);
        return $planes;
    }
    protected function getAirports(): array
    {
        $airportsRepo = new AirportRepository();
        $airports = $airportsRepo->getAll(PDO::FETCH_CLASS);
        $airportLocations = [];

        // if airport's city name is not found use airport name
        // and IF airports name is not found use airport code
        foreach ($airports as $airport) {
            $airportLocations[$airport->getId()] = 
                ($airport->getCity() === "" ? 
                        ($airport->getAirportName() === "" ? $airport->getCode() :
                                $airport->getAirportName() ) : $airport->getCity()) .
                 "&#47;" . $airport->getCountry();
        }
        asort($airportLocations);
        return $airportLocations;
    }

}
