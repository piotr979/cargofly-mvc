<?php

declare(strict_types = 1);

namespace App\Fixtures;

class UserFixture extends AbstractFixture
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    public function addUserTable()
    {
        $mysql = "CREATE TABLE user
            (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                login VARCHAR(40) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(40) NOT NULL,
                PRIMARY KEY (id)
            )
            ";
          
        $this->modifyDatabase($mysql);
    }
    public function addNewUser($login, $pass, $role = "ROLE_USER")
    {

        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $mysql = "INSERT INTO 
                    user (login, password, role)
                    VALUE ( :login, :password, :role )";
                    
        $this->modifyDatabase($mysql, 
                            [
                            'login' => $login, 
                            'password' => $hashedPass,
                            'role' => "ROLE_ADMIN"
                            ]
                    );
    }
}