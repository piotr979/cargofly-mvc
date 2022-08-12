<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;
use PDO;

class AbstractRepository 
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getById(int $id, string $entity)
    {
        
        $stmt = $this->conn->prepare('SELECT * FROM ' . $entity);
       // $stmt->bindValue(':stick', 'usero', PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        dump($user);exit;
    }
}