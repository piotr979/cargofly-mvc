<?php

declare(strict_types = 1);

namespace App\Fixtures;


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

    private function runFixtures()
    {
        $userFixture = new UserFixture($this->conn);
       //$this->addUsersTable($userFixture);
       $this->addNewUser('admin@admin.com', '123456', $userFixture, "ROLE_ADMIN");
    }

    private function addUsersTable(object $userFixture)
    {
        $userFixture->addUserTable();
    }

    private function addNewUser(
                                string $login, 
                                string $pass, 
                                object $userFixture, 
                                string $role
                                )
    {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $userFixture->addNewUser($login, $hashedPass, $role);
    }
}