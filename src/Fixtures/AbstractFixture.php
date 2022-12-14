<?php

declare(strict_types = 1);

namespace App\Fixtures;

use App\Models\Database\PDOClient;
/**
 * Some basic stuff for fixtures
 * @param $conn connection to the database return by database client's class
 */
class AbstractFixture
{
    protected $conn;
    protected $db;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
    }

    /**
     * Modifies database by executing mysql code,
     * @param string $mysql 
     * @param array $params consists of two elements key and value for bindValue
     */

    public function modifyDatabase(string $mysql, array $params = []): void
    {
        $stmt = $this->conn->prepare($mysql);

        if (!empty($params)) {
            foreach($params as $key => $value) {
                $stmt->bindValue($key, $value);

            }
        }
        if (!$stmt->execute()) {
            echo "Error with executing mysql";
        };
    }
    public function runSql(string $sql)
    {
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt->execute()) {
            echo "Error with executing mysql";
        };

    }
} 