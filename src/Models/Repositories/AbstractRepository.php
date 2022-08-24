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
        
        $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName);
       // $stmt->bindValue(':stick', 'usero', PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        dump($user);exit;
    }
    public function getAll(string $tableName)
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName);
        $stmt->execute();
    }
}