<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\App;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\EntityInterface;
use PDO;

class AbstractRepository 
{
    protected $conn;

    public function __construct()
    {
        $this->conn = App::$app->conn;
    }
    public function getById(int $id, string $tableName)
    {
        
        $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName . ' WHERE id = :id');
       $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll(string $tableName)
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}