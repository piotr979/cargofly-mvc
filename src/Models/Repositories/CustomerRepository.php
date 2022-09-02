<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Repositories\AbstractRepository;
use PDO;

class CustomerRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getAllCustomersPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
        // TODO: CHeck if serach string is given
        $searchStr = "'%" . $searchString . "%'";
      
        $offset = ($page - 1 ) * 10;
        $sql = "SELECT 
            *
             FROM customer
             LEFT JOIN customer_cargos
            ON customer.cargos = customer_cargos.id
            ";
            if ($searchColumn != '') {
                $sql .=  " WHERE " . $searchColumn . " LIKE " . $searchStr;
             }
            $sql .= " ORDER BY " . $sortBy;
            $sortOrder == 'asc' ? $sql .= ' ASC' : $sql .= ' DESC';
            $sql .= " LIMIT 10 OFFSET :offset";
            dump($sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
         
        $stmt->execute();
       // dump($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchString(string $search, string $column)
    {
        $searchStr = "'%" . $column . "%'";
        $sql = "
            SELECT * FROM aircraft WHERE " . $column . " LIKE " . $searchStr;
        
        $stmt = $this->conn->prepare($sql);
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
    public function remove($id)
    {
        if ($this->removeById($id, $this->getEntityNameFromRepoName())) {
            return true;
        } else {
            return false;
        };
    }
}