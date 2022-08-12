<?php

declare(strict_types = 1);

namespace App\Models\Entities;

use App\Models\Entities\AbstractEntity;

class UserEntity extends AbstractEntity
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    /**
     * @var username
     */

     private $userName;
     /**
      * @var role
      */

    private $role;
    public function getuserName()
    {
        return $this->userName;
    }
    public function setUserName(string $name)
    {
        $this->userName = $name;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole(string $role)
    {
        $this->role = $role;
    }
}