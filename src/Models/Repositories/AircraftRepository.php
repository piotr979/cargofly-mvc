<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;
use PDO;

class AircraftRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllAircrafts()
    {
      
        $stmt = $this->conn->prepare('SELECT 
            aircraft.id, aircraft_name, hours_done, in_use, airport_base,
            vendor, model, payload, city
             FROM aircraft
            LEFT JOIN aeroplane
            ON  aircraft.aeroplane = aeroplane.id
            LEFT JOIN airport
            ON aircraft.airport_base = airport.id');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 
     * Saves to database
     * If id is different than 0 means it's editing existing entry
     */
    public function persist($aircraft)
    {

        if ($aircraft->getId() === 0) {
        $mysql = "
            INSERT INTO aircraft
                ( aircraft_name, hours_done, in_use, airport_base, aeroplane) 
                VALUES
                ( :aircraftName, :hoursDone, :inUse, :airportBase, :aeroplane)
                ";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue( ":aircraftName", $aircraft->getAircraftName());
        $stmt->bindValue( ":hoursDone", $aircraft->getHoursDone());
        $stmt->bindValue( ":inUse", $aircraft->isInUse());
        $stmt->bindValue( ":airportBase", $aircraft->getAirportBase());
        $stmt->bindValue( ":aeroplane", $aircraft->getAeroplane());
        $stmt->execute();

        } else {
            $mysql = "
            UPDATE aircraft 
            SET 
                aircraft_name = :aircraftName,
                airport_base = :airportBase,
                aeroplane = :aeroplane
            WHERE id = :id
            ";
            $stmt = $this->conn->prepare($mysql);
            $stmt->bindValue( ":aircraftName", $aircraft->getAircraftName());
            $stmt->bindValue( ":airportBase", $aircraft->getAirportBase());
            $stmt->bindValue( ":aeroplane", $aircraft->getAeroplane());
            $stmt->bindValue( ":id", $aircraft->getId());
            $stmt->execute();

        }

    }

}