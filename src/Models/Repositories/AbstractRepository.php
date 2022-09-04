<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\App;

use PDO;
use App\Models\Database\QueryBuilder;
use ReflectionClass;

class AbstractRepository 
{
    protected object $db;
    protected QueryBuilder $qb;
    protected string $entityName;

    public function __construct(string $entityName)
    {
        $this->qb = new QueryBuilder($entityName);
        $this->entityName = $entityName;
        dump($this->qb);
        $this->db = App::$app->db;
    }
    public function getAll()
    {   
        $query = $this->qb->select('*')
                 ->from($this->entityName)
                 ->getQuery();      

        return $this->db->runQuery($query);
    }
    public function getById2(int $id)
    {
        $query = $this->qb
                        ->select('*')
                        ->from($this->entityName)
                        ->where('id', (string)$id)
                        ->getQuery();
        return $this->db->runQuery($query);
    }
    public function getById(int $id, string $tableName, string $entityName)
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName . ' WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('\App\Models\Entities\\' . $entityName);
    }
    // public function getAll(string $tableName)
    // {
    //     $stmt = $this->conn->prepare('SELECT * FROM ' . $tableName);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function getAllBy(string $sortBy, string $sortOrder, string $table)
    {
        $sql = 'SELECT * FROM :table ORDER BY :sortBy ' . $sortOrder === 'asc' ? 'ASC' : 'DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':table', $table);
        $stmt->bindValue(':sortBy', $sortBy);
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    public function checkIfExists(string $entry, string $column, string $table)
    {
        $sql = "SELECT :column FROM " . $table . " WHERE " . $column . " = :entry";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':column', $column, PDO::PARAM_STR);
        $stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
        $stmt->execute();

         if (!empty($stmt->fetchAll())) {
            return true;
         } else {
            return false;
         }
    }
}