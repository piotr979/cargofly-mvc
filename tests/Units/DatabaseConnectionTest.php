<?php

namespace Test\Units;

use PHPUnit\Framework\TestCase;
use App\Models\Database\PDOClient;
use PDO;

class DatabaseConnectionTest extends TestCase
{

    private $connection;

    public function testItCanConnectToDatabaseWithPDO()
    {
        $this->connection = new PDO('mysql:host=db;dbname=cargo_mvc', 'user', '123456');
        
        self::assertNotNull($this->connection);
        
    }
}