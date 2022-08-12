<?php

declare(strict_types = 1);

namespace App\Models\Database;

use App\Models\Database\Database;
use PDO;
use App\Exceptions\ConnectionException;

class PDOClient extends Database
{
    private string $dsn;

    public function __construct($driver, $host, $db_name, $db_user, $db_password)
    {
        parent::__construct($host, $db_name, $db_user, $db_password);
        $this->dsn = "{$driver}:host={$this->host};dbname={$this->db_name};
                    ";
    }
    public function connect()
    {
            $this->connection = new PDO($this->dsn, $this->db_user, $this->db_password);
            return $this;
    }
}