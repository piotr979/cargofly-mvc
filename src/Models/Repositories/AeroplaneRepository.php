<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\EntityInterface;
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
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

}