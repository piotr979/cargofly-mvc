<?php

namespace Test\Units;

use PHPUnit\Framework\TestCase;
use App\Models\Database\PDOClient;
use App\Models\Repositories\AircraftRepository;
use PDO;


class DatabaseConnectionTest extends TestCase
{

    private $db;

    public function testItCanConnectToDatabaseWithPDO()
    {

        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        self::assertNotNull($this->db);
        
    }
}