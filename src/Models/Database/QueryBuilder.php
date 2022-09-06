<?php

declare(strict_types = 1);
namespace App\Models\Database;

class QueryBuilder
{
    private string $table;
    private string $query;
    private string $entity;

    public function __construct(string $entity) 
    {
        $this->query = '';
        $this->entity = $entity;
    }
    public function select(string|array $args): object
    {
        $this->query .= "SELECT ";
        $this->query .= $this->prepareArgs($args);
        return $this;
    }
    /**
     * Insert into array. Entity taken from property $entity
     * passed as param to constructor
     */
    public function insert(string|array $args, string|array $values)
    {
        $this->query = "INSERT INTO " . $this->entity;
        $this->query .= " ( " . $this->prepareArgs($args) . " )";
        $this->query .= " VALUE ";
        $this->query .= " ( " . $this->prepareArgs($values, quotes: true) . " )";
        return $this;
    }

    public function from(string $from): object
    {
        $this->query .= " FROM " .$from; 
        return $this;
    }
    public function where(string $param, string $equals)
    {
        $this->query .= " WHERE " . $param . " = " . "'" . $equals . "'";
        return $this;
    }
    public function whereLike(string $param, string $like)
    {
        if ($like === '') {
            return $this;
        }
        $searchStr =  "'%" . $like . "%'";
        $this->query .=" WHERE " . $param . " LIKE " . $searchStr;
        return $this; 
    }
    public function orderBy(string $orderBy, string $sortDirection = 'ASC')
    {
        $this->query .= " ORDER BY " . $orderBy . " " . $sortDirection;
        return $this;
    }
    public function limitWithOffset(int $limit, int $offset)
    {
        $this->query .= " LIMIT " . $limit . " OFFSET " . $offset;
        return $this;
    }
    public function remove(int $id, string $entityName)
    {
        $this->query .= "DELETE FROM " .$entityName . " WHERE id = " . $id;
        return $this; 
    }
    public function leftJoin(string $entityName, string $on, string $equals)
    {
        $this->query .= " LEFT JOIN " . $entityName . " ON " . $on . " = " . $equals ; 
        return $this;
    }
    public function update(string $tableName, array $args, array $values, int $id)
    {
        $this->query .= "UPDATE " . $tableName . " SET ";
        for($i=0; $i<count($args); $i++) {

            $this->query .= $args[$i] . " = '" . $values[$i] . "',";
        }
        $this->query = substr_replace($this->query, " ", -1);
        $this->query .= " WHERE id = " . $id;
      //  dump($this->query);exit;
        return $this;
    }
    public function getQuery(): string
    {
        // query copy is needed to reset the query string
        $queryCopy = $this->query;
        $this->query = '';
        return $queryCopy;
    }

    /**
     * Creates list of arguments inserted to query
     * for example name, address, street,etc.
     */
    private function prepareArgs(string|array $args, bool $quotes = false)
    {
        $q = '';
        if (is_array($args)) {
            foreach($args as $key => $arg) {
                    if ($quotes) {
                        $q .= "'"; 
                    }
                if ($key != array_key_last($args)) {
                    $q .= $arg . ($quotes == true ? "', ": ", ") ;
                } else {
                    $q .= $arg . ($quotes == true ? "' " : "");
                }
            }
        } else {
            $q .= $args;
        }
        return $q;
    }

}