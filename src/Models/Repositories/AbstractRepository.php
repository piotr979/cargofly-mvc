<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\App;
use App\Helpers\Url;
use PDO;
use Reflection;
use ReflectionClass;

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
    public function countPages(int $limit, string $table): int
    {
        $sql = "SELECT COUNT(id) AS count FROM " . $table;
        $stmt = $this->conn->prepare($sql);
       //  $stmt->bindValue(":name", "aircraft", PDO::PARAM_STR);

        $stmt->execute();

        $entries = $stmt->fetch()['count'];

        // now divide entries by given limit per page,
        // round it up and cast to int
        return (int)ceil($entries / $limit);
    }

    protected function removeById($id, string $entity): bool
    {
        $mysql = "DELETE FROM aircraft WHERE id = :id";
        $stmt = $this->conn->prepare($mysql);
       // $stmt->bindValue( ":entity", $entity, PDO::PARAM_STR);
        $stmt->bindValue( ":id", $id, PDO::PARAM_INT);
      
       return $stmt->execute();
    }
    protected function getEntityNameFromRepoName(): string
    {
            // Remove item as long as our repostitory name
        // contains Repository in string name
        $reflect = new ReflectionClass($this);

        // remove "Repository" word from the string
        $entity = trim(str_replace('Repository','',$reflect->getShortName()));
        return $entity;
    }

}