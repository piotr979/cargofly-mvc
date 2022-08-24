<?php

declare(strict_types = 1);

namespace App\Models\Database;

use App\Models\Entities\EntityInterface;
use App\Models\Repositories\RepositoryInterface;

/**
 * This class is a foundation for any other database driver
 */
abstract class Database
{
    protected $connection;
    protected $statement;
    protected $host, $db_name, $db_user, $db_pass;

    public function __construct($host, $db_name, $db_user, $db_password)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
    }

    abstract function connect();

    public function select($sql)
    {
        $this->statement = $this->connection->query($sql);
        return $this;
    }
    public function getConnection()
    {
        return $this->connection;
    }
    public function persist(RepositoryInterface $repo, $object)
    {
        $repo->persist($object);
    }
}