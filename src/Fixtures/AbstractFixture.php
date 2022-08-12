<?php

declare(strict_types = 1);

namespace App\Fixtures;

/**
 * Some basic stuff for fixtures
 * @param $conn connection to the database return by database client's class
 */
class AbstractFixture
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Modifies database simply by executing mysql code,
     * @param string $mysql 
     * @param array $params consists of two elements key and value for bindValue
     */

    public function modifyDatabase($mysql, $params = [])
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
} 