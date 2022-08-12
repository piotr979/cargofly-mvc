<?php

declare(strict_types = 1);

namespace App\Fixtures;

/**
 * This class creates fixtures
 */
class FixtureLauncher
{

    private $conn;
    /**
     * FIXTURES 
     * 
     * This function is launched only if uncommented in run() function
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->runFixtures();
    }

    /**
     * Add/remove methods to run fixtures.
     */
    private function runFixtures()
    {
       $userFixture = new UserFixture($this->conn);
       //$userFixture->addUserTable();
       //$userFixture->addNewUser('admin@admin.com', '123456', $userFixture, "ROLE_ADMIN");
    }

}