<?php

declare(strict_types = 1);

namespace App\Models\Database;

use App\Models\Database\Database;
use PDO;
use App\Exceptions\ConnectionException;

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
            $this->connection = new PDO($this->dsn, $this->db_user, $this->db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this;
    }
    public function runQuery(string $query, array $params = []): array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}