<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Helpers\Url;
use App\Models\Repositories\AbstractRepository;
use PDO;

class AeroplaneRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllPlaneModels()
    {
      
        $stmt = $this->conn->prepare('SELECT * FROM aeroplane');
        $stmt->setFetchMode(PDO::FETCH_CLASS, '\App\Models\Entities\AeroplaneEntity');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function persist($plane)
    {
        $mysql = "
            INSERT INTO aeroplane
                ( vendor, photo, model, payload) 
                VALUES
                ( :vendor, :photo, :model, :payload )
                ";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue( ":vendor", $plane->getVendor());
        $stmt->bindValue( ":photo", $plane->getPhoto());
        $stmt->bindValue( ":model", $plane->getModel());
        $stmt->bindValue( ":payload", $plane->getPayload());
         
        $stmt->execute();
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
        // not required implementation for now
        return 0;
    }

    public function remove($id)
    {
        $mysql = "DELETE FROM aeroplane WHERE id = :id";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue( ":id", $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $this->flashMessenger->add('Item removed.');
            Url::redirect('/dashboard');
        } else {
            $this->flasMessenger->add('Something wrong. Operation terminated.');
        };
    }

}