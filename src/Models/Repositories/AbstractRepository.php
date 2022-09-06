<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\App;

use PDO;
use App\Models\Database\QueryBuilder;
use App\Models\Entities\EntityInterface;
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
        $this->db = App::$app->db;
    }
    public function getAll($mode = PDO::FETCH_ASSOC)
    {   
        $query = $this->qb->select('*')
                 ->from($this->entityName)
                 ->getQuery();      
        if ($mode === PDO::FETCH_CLASS) {
        return $this->db->runQuery($query, false,
                        "\App\Models\Entities\\" . ucfirst($this->entityName) . "Entity");
        }
        return $this->db->runQuery($query);
    }
    public function getWhere(string $entry, string $column, string $equals)
    {
        $query = $this->qb
                ->select($entry)
                ->from($this->entityName)
                ->where($column, $equals)
                ->getQuery()
                ;
        return $this->db->runQuery($query, true);
    }
    /**
     * saves Entity in database
     * @param array $columns Columns names (from Repository)
     * @param object $object Entity object 
     */
    public function persistTo(array $columns, EntityInterface $object)
    {
        $values = [];
        $class = get_class($object);
       
        if ($class) {
            $getters = array_filter(get_class_methods($class), function ($method) {
                return 'get' === substr($method, 0, 3);
            });
        }
        foreach ($getters as $getter) {
            $values[] = $object->$getter();
        }
        if (end($values) == 0) {
            // if id == '' , remove id
            array_pop($values);
            $query = $this->qb  
                           ->insert($columns, $values)
                           ->getQuery()
                            ;
        } else {
                // we have ID, therefore we must ID to columns array
                
            $query = $this->qb
                        ->update(tableName: $this->entityName, 
                                            args: $columns, 
                                            values: $values, 
                                            id: $object->getId() 
                                            )
                        ->getQuery();
        }
       return $this->db->pushQuery($query);
    }
    public function getById(int $id)
    {
        $query = $this->qb
                        ->select('*')
                        ->from($this->entityName)
                        ->where('id', (string)$id)
                        ->getQuery();
      
        return $this->db->runQuery(query: $query, single: true, classAssoc: 
                        "\App\Models\Entities\\" . ucfirst($this->entityName) . "Entity");
    }

    protected function removeById(int $id): bool
    {
        $query = $this->qb
                        ->remove($id, $this->entityName)
                        ->getQuery();
        $result = $this->db->getConnection()->exec($query);

        if ($result === 1) {
            return true;
        }
        return false;
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
    public function checkIfExists(string $entry, string $column)
    {
        $query = $this->qb
                    ->select($column)
                    ->from($this->entityName)
                    ->where(param: $column, equals: $entry)
                    ->getQuery();
        if (!empty($this->db->runQuery($query))) {     
                return true;
        } else {
                return false;

            }
    }
}