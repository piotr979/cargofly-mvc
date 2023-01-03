<?php

declare(strict_types = 1);

namespace App\Models\Database;

use App\Models\Database\Database;
use PDO;
use App\Exceptions\ConnectionException;
use PDOException;

class PDOClient extends Database implements DatabaseClientInterface
{
    private string $dsn;

    public function __construct($driver, $host, $db_name, $db_user, $db_password)
    {
        parent::__construct($host, $db_name, $db_user, $db_password);
        $this->dsn = "{$driver}:host={$this->host};dbname={$this->db_name};
                    ";
    }
    public function connect(): object
    {
            
            try {
                $this->connection = new PDO($this->dsn, $this->db_user, $this->db_password);
            }  catch ( PDOException $e) {
                print "Error: " . $e->getMessage();
                exit;
            }
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this;
    }
    /**
     * Runs the query. 
     * @param string $query Built by Query Builder
     * @param bool $single Only one element is fetched
     * @param string $classAssoc class associated with FETCH_CLASS
     * 
     * @return return single or multiple results (entries)
     */
    public function runQuery(string $query, bool $single = false, string $classAssoc = ''): mixed
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($classAssoc != '') {
            if ($single) {
                return $stmt->fetchObject($classAssoc);
            } else {
                return $stmt->fetchAll(PDO::FETCH_CLASS, $classAssoc);
            }
        } else {
            if ($single) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    public function pushQuery(string $query)
    {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $this->connection->lastInsertId();
    }
}