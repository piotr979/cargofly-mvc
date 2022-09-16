<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;

class AeroplaneRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct('aeroplane');
    }

    public function getAllPlaneModels()
    {
        
        // $stmt = $this->conn->prepare('SELECT * FROM aeroplane');
        // $stmt->setFetchMode(PDO::FETCH_CLASS, '\App\Models\Entities\AeroplaneEntity');
        // $stmt->execute();
        // return $stmt->fetchAll();
    }
    public function persist(EntityInterface $aeroplane)
    {
        parent::persistTo(
            columns: [
                "vendor", 
                "photo", 
                "model", 
                "payload", 
                "distance"
               ], 
           object: $aeroplane);
    }
    /**
    * not required implementation for now
    **/
    public function countPages(int $limit, 
                                string $searchString = '',
                                string $searchColumn = ''): int
    {
        return 0;
    }
}