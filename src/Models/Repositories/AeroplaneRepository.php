<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Repositories\AbstractRepository;
use PDO;

class AeroplaneRepository extends AbstractRepository
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    public function getAllPlaneModels()
    {
        $stmt = $this->conn->prepare('SELECT * FROM aeroplane');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}