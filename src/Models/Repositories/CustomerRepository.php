<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Database\QueryBuilder;
use App\Models\Repositories\AbstractRepository;
use PDO;

class CustomerRepository extends AbstractRepository implements RepositoryInterface
{

    public function __construct()
    {
        parent::__construct('customer');
    }
    public function persist2(string|array $args, string|array $values)
    {   
        $query = $this->qb->insert($args, $values)
                 ->getQuery();        
        ;
        dump($query);exit;

    }

    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
        // TODO: CHeck if serach string is given
        $searchStr = "'%" . $searchString . "%'";
      
        $offset = ($page - 1 ) * 10;
        $sql = "SELECT * FROM customer ";

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
    public function persist($customer)
    {
        if ($customer->getId() === 0) {
        $mysql = "
            INSERT INTO customer
                ( customer_name, owner_fname owner_lname, street1, street2, 
                    city, zip_code, country, vat, logo) 
                VALUES
                ( :customerName, :ownerFName, :ownerLName, :street1, :street2,
                  :city, :zipCode, :country, :vat, :logo)
                ";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue( ":customerName", $customer->getCustomerName());
        $stmt->bindValue( ":ownerFName", $customer->getOwnerLName());
        $stmt->bindValue( ":ownerLName", $customer->getOwnerFName());
        $stmt->bindValue( ":street1", $customer->getStreet1());
        $stmt->bindValue( ":street2", $customer->getStreet2());
        $stmt->bindValue( ":city", $customer->getCity());
        $stmt->bindValue( ":zipCode", $customer->getZipCode());
        $stmt->bindValue( ":country", $customer->getCountry());
        $stmt->bindValue( ":vat", $customer->getVat());
        $stmt->bindValue( ":logo", $customer->getLogo());
       
        $stmt->execute();
        } else {
            $mysql = "
            UPDATE customer
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
    /**
     * Counts pages. The problem was to get proper amount of entries
     * as when search form was submitted it had to be taken into account
     * otherwise it always returned full table with all entries
     */
    public function countPages(int $limit, 
                                string $searchString = '',
                                string $searchColumn = ''): int
    {
        $searchStr = "'%" . $searchString . "%'";
        $sql = "SELECT COUNT(customer.id) AS count FROM customer";
        if ($searchColumn != '') {
            $sql .=' WHERE ' . $searchColumn . ' LIKE ' . $searchStr;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $entries = $stmt->fetch()['count'];

        // now divide entries by given limit per page,
        // round it up and cast to int
        return (int)ceil($entries / $limit);
    }

    public function persister($object)
    {
        $getters = []; $values = []; 
        
        $sql = '';

        $columns = ['customer_name', 'owner_fname', 'owner_lname', 'street1', 
        'street2', 'city', 'zip_code', 'country', 'vat', 'logo'];
        $class = get_class($object);
        if ($class) {
            $getters = array_filter(get_class_methods($object), function($method) {
                return 'get' === substr($method, 0, 3);
            });
        }
        foreach($getters as $getter) {
                $values[] = $object->$getter();
        }
        // we have to move id from the end of the array to the front
        // ID is last because $getter getId was called last
     //  $valuesSorted = array_merge(array_splice($values, -1), $values);

       // if id = '' means new customer is being created 
       // (id is the last element in array)
        if (end($values) == '') {
            // if id == '' , remove id
            array_pop($values);
            $sql = "INSERT INTO customer (" . implode(',', $columns) . ")  
                VALUES (";
                    foreach($values as $key => $value) {
                            if ($key != array_key_last($values)) {
                        $sql .= "'" . $value . "',";
                            } else {
                                $sql .= "'" . $value . "'";
                            }
                    }
                $sql .= ")";
        } else {
            // we have ID, therefore we must ID to columns array
            array_push($columns, 'id');
            $sql = "UPDATE customer SET ";
            for ($i=0; $i<(count($columns) - 1); $i++) {
                $sql = $columns[$i] . " = " . $values[$i] . ",";
            }
            $sql .= "WHERE " . end($columns) . " = " . end($valuesSorted);
        }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
    }
}   